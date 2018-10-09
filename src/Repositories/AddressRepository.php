<?php

namespace Viviniko\Address\Repositories;

interface AddressRepository
{
    /**
     * Paginate the given query into a simple paginator.
     *
     * @param $perPage
     * @param string $searchName
     * @param null $search
     * @param null $order
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage, $searchName = 'search', $search = null, $order = null);

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