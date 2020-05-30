<?php

namespace App\Http\Requests;

use App\Exceptions\RepositoryException;
use App\Http\Repositories\Repository;
use Closure;
use Illuminate\Pagination\LengthAwarePaginator;
use Lang;

class DataListingRequest extends ApiRequest
{
    private $additionalFilter = [];

    /**
     * @return string
     */
    public function message(): string
    {
        return Lang::get('messages.request.dataListingRequest');
    }

    /**
     * @return string
     */
    public function messageCode(): string
    {
        return Lang::get('codes.request.dataListingRequest');
    }

    /**
     * @param array $filter
     */
    public function setAdditionalFilter(array $filter) : void
    {
        $this->additionalFilter = $filter;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        $data = collect($this->all());

        $filters = $data->get('filters') ?? [];
        $data['filters'] = array_merge($filters, $this->additionalFilter);

        return $data->only([
            'grouped',
            'search',
            'filters',
            'limit',
            'orderBy',
            'page'
        ])->all();
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'grouped' => 'bail|nullable|boolean',
            'search' => 'bail|nullable|string',
            'filters' => 'bail|nullable|array',
            'limit' => 'bail|nullable|integer|min:1',
            'orderBy' => 'bail|nullable|string',
            'page' => 'bail|nullable|integer|min:1',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'grouped.boolean' => $this->formatRequestError(
                'grouped',
                'Agrupamento deve conter um valor lógico: 1 ou 0'
            ),

            'search.string' => $this->formatRequestError(
                'search',
                'O campo Search deve ser uma string'
            ),

            'filters.array' => $this->formatRequestError(
                'filters',
                'O campo filters deve ser um array'
            ),

            'limit.integer' => $this->formatRequestError(
                'limit',
                'O campo Limit deve ser um inteiro'
            ),

            'limit.min' => $this->formatRequestError(
                'limit',
                'O menor valor a ser utilizado no campo Limit é 1'
            ),

            'page.integer' => $this->formatRequestError(
                'page',
                'O campo Page deve ser um inteiro'
            ),

            'page.min' => $this->formatRequestError(
                'page',
                'O menor valor a ser utilizado no campo Page é 1'
            ),

            'orderBy.string' => $this->formatRequestError(
                'orderBy',
                'O campo Search deve ser uma string'
            ),
        ];
    }

    /**
     * @param string $class
     * @param Closure|null $filter
     * @return LengthAwarePaginator
     * @throws RepositoryException
     */
    public function listData(string $class, Closure $filter = null) : LengthAwarePaginator
    {
        return Repository::listData($class, $this, $filter);
    }
}
