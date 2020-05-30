<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Query;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class QueryController extends Controller
{

    /**
     *
     * @return Renderable
     */
    public function index()
    {
        return view('home', ['queries' => Query::all()]);
    }

    public function show(Request $request, Query $query)
    {

        $listings = $query->listings();

        $data = [
            'query_id' => $query->id,
            'search_key' => $query->search_key,
        ];

        $minPrice = $request->get('price_min') ?? 0;
        $maxPrice = $request->get('price_max') ?? PHP_FLOAT_MAX;

        if($minPrice > 0 && $minPrice <= $maxPrice) {
            $listings->where('price', '>=', $request->get('price_min') ?? 0);
            $data['minPrice'] = $minPrice;
        }

        if($maxPrice != PHP_FLOAT_MAX && $maxPrice >= $minPrice) {
            $listings->where('price', '<=', $request->get('price_max') ?? PHP_FLOAT_MAX);
            $data['maxPrice'] = $maxPrice;
        }

        if($request->has('sort')) {
            [$field, $order] = explode('_', $request->get('sort'));
            $listings->orderBy($field, $order);
            $data['sort'] = ['field' => $field, 'order' => $order];
        }

        $data['listings'] = $listings->unread()->get();

        return view('query', $data);
    }

    /**
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function create(Request $request)
    {
        $searchKey = $request->get('searchKey');

        $query = new Query([
            'search_key' => $searchKey
        ]);

        $query->save();
        $this->doSync($query);

        return redirect()->route('home');

    }

    /**
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function edit(Request $request, Query $query)
    {
        $searchKey = $request->get('searchKey');

        $query->search_key = $searchKey;
        $query->save();

        return response()->json(json_encode(['status' => 'ok']), Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);

    }

    public function delete(Request $request, Query $query)
    {
        try {

            $query->delete();

        } catch (\Exception $e) {

            Log::error('error deleting query: ', [
                'id' => $query->id,
                'message' => $e->getMessage()
            ]);

            return response()->json(json_encode(['status' => 'error']), Response::HTTP_INTERNAL_SERVER_ERROR, [], JSON_UNESCAPED_UNICODE);
        }

        return response()->json(json_encode(['status' => 'ok']), Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }

    public function sync(Request $request, Query $query)
    {
        $this->doSync($query);

        $unreadListingsCount = $query->listings()
            ->unread()
            ->count();

        return response()->json(json_encode(['unread_listings' => $unreadListingsCount]), Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }

    public function markListingAsRead(Request $request, Query $query, Listing $listing)
    {
        if($query->listings()->where('id', $listing->id)->exists()) {

            $listing->markAsRead();
            $listing->save();

        }

        return response()->json(json_encode(['status' => 'ok']), Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);

    }

    public function bulkMarkListingsAsRead(Request $request, Query $query)
    {

        $query->listings()
              ->whereIn('id', $request->get('listingIds'))
              ->get()
              ->transform(function ($listing) {
                  $listing->markAsRead();
                  $listing->save();
                  return $listing;
              });

        return response()->json(json_encode(['status' => 'ok']), Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }

    public function doSync(Query $query)
    {
        $client = new Client();
        $results = [];
        $offset = 0;

        Log::info('Synchronizing search key: ' . $query->search_key);

        do {

            $response = $client->request('GET', 'https://api.mercadolibre.com/sites/MLB/search', [
                'query' => [
                    'q' => $query->search_key,
                    'offset' => $offset
                ]
            ]);

            $contents = json_decode($response->getBody()->getContents(), true);
            $contentResults = $contents['results'];

            foreach ($contentResults as $contentResult) {
                $results[] = $contentResult;
            }

            $offset += (int)$contents['paging']['limit'];

        } while ($offset < 1000 && count($contents['results']) > 0);

        $results = collect($results);

        $listingsAlreadySaved = $query->listings()
            ->whereIn('listing_id', $results->pluck('id'))
            ->pluck('listing_id');

        $listingsToBeSaved = $results->whereNotIn('id', $listingsAlreadySaved);
        $listingModels = [];

        foreach ($listingsToBeSaved as $listingToBeSaved) {

            $listingModels[] = new Listing([
                'listing_id' => $listingToBeSaved['id'],
                'title' => $listingToBeSaved['title'],
                'price' => $listingToBeSaved['price'],
                'condition' => $listingToBeSaved['condition'],
                'thumbnail' => $listingToBeSaved['thumbnail'],
                'url' => $listingToBeSaved['permalink']
            ]);
        }

        //TODO: adicionar na contagem os anuncios marcados como nao lidos
        $query->listings()->saveMany($listingModels);

        return $listingModels;

    }

}
