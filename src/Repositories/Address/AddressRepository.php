<?php

namespace Viviniko\Address\Repositories\Address;

interface AddressRepository
{
    public function find($id);

    /**
     * List addresses.
     *
     * @param mixed $addressable
     * @return \Illuminate\Support\Collection
     */
    public function lists($addressable);

    public function create(array $data);

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