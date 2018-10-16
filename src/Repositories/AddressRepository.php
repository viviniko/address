<?php

namespace Viviniko\Address\Repositories;

use Viviniko\Repository\SearchRequest;

interface AddressRepository
{
    /**
     * Search.
     *
     * @param SearchRequest $searchRequest
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function search(SearchRequest $searchRequest);

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    public function findBy($column, $value = null, $columns = ['*']);

    /**
     * List addresses.
     *
     * @param mixed $addressable
     * @return \Illuminate\Support\Collection
     */
    public function lists($addressable);

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data);

    /**
     * Address is exists.
     *
     * @param $column
     * @param null $value
     * @return mixed
     */
    public function exists($column, $value = null);
}