<?php

namespace Viviniko\Address\Repositories\Address;

interface AddressRepository
{
    public function find($id);

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