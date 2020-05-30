@extends('layout')
@section('js')
    <script src="{{ mix('js/listings.js') }}" defer></script>
@endsection
@section('content')
    <div class="row justify-content-center text-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="float-sm-left">
                        <a class="text-muted" href="{{ route('home') }}">
                            <i class="fas fa-arrow-left fa-pull-left"></i>
                        </a>
                        {{ $search_key }}
                    </h4>
                    <div class="float-sm-right">
                        <form id="filter-by-price" action="{{ route('query.show', ['query'=> $query_id]) }}" method="get">
                            <div class="form-row">
                                <div class="col">
                                    <input id="min-price"
                                           name="price_min"
                                           class="form-control price-filter"
                                           type="number"
                                           min="0"
                                           @if(isset($minPrice)) value="{{ $minPrice }}" @else placeholder="min" @endif>
                                </div>
                                <div class="col">
                                    <input id="max-price"
                                           name="price_max"
                                           class="form-control price-filter"
                                           type="number"
                                           min="0"
                                           @if(isset($maxPrice)) value="{{ $maxPrice }}" @else placeholder="max" @endif>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="{{ $query_id }}" class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>
                                    @if(isset($sort) && $sort['field'] == 'price')

                                        @if($sort['order'] == 'asc')
                                            <a class="text-muted" href="{{ route('query.show', ['query' => $query_id, 'sort' => 'price_desc', 'price_min' => $minPrice ?? '', 'price_max' => $maxPrice ?? '']) }}">
                                                Price<i class="fas fa-sort-down fa-pull-right"></i>
                                            </a>
                                        @else
                                            <a class="text-muted" href="{{ route('query.show', ['query' => $query_id, 'price_min' => $minPrice ?? '', 'price_max' => $maxPrice ?? '']) }}">
                                                Price<i class="fas fa-sort-up fa-pull-right"></i>
                                            </a>
                                        @endif

                                    @else
                                        <a class="text-muted" href="{{ route('query.show', ['query' => $query_id, 'sort' => 'price_asc', 'price_min' => $minPrice ?? '', 'price_max' => $maxPrice ?? '']) }}">
                                            Price<i class="fas fa-sort fa-pull-right"></i>
                                        </a>
                                    @endif
                                </th>
                                <th>Condition</th>
                                <th></th>
                                <th>
                                    <i id="delete-selected-listings" class="far fa-trash-alt" role="button"></i>
                                </th>
                                <th>
                                    <input id="toggle-all-listings" type="checkbox">
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($listings as $listing)
                                <tr id="{{$listing->id}}">
                                    <td>{{ $listing->title }}</td>
                                    <td>R${{ $listing->price }}</td>
                                    <td class="text-capitalize">{{ $listing->condition }}</td>
                                    <td>
                                        <a href="{{ $listing->url }}">
                                            <img src="{{ $listing->thumbnail }}" alt="thumbnail">
                                        </a>
                                    </td>
                                    <td>
                                        <i class="delete-listing far fa-trash-alt" role="button"></i>
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" class="toggle-listing form-check-input">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
