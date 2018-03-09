<?php

namespace Viviniko\Address\Contracts;

interface AddressService
{
    /**
     * Paginate addresses.
     *
     * @param mixed $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function search($query);

    /**
     * Find address.
     *
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * Create new Address.
     *
     * @param $addressable
     * @param $data
     * @return mixed
     */
    public function create($addressable, array $data);

    /**
     * Update address.
     *
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, array $data);

    /**
     * Delete a address in repository by id
     *
     * @param $id
     *
     * @return int
     */
    public function delete($id);

    /**
     * Save a new address in repository
     *
     * @param array $data
     * @param Model $addressable
     *
     * @return mixed
     */
    public function createIfNotExists($addressable, array $data);

    /**
     * Get exists address.
     *
     * @param $addressable
     * @param array $data
     * @return mixed
     */
    public function getExistsAddress($addressable, array $data);

    /**
     * Has default address.
     *
     * @param $addressable
     * @return mixed
     */
    public function hasDefaultAddress($addressable);

    /**
     * Get default address.
     *
     * @param $addressable
     * @return mixed
     */
    public function getDefaultAddress($addressable);

    /**
     * Has default address.
     *
     * @param $addressable
     * @param int|Address $address
     * @return mixed
     */
    public function setDefaultAddress($addressable, $address);

    /**
     * Guess client address.
     *
     * @return mixed
     */
    public function guessClientAddress();

    /**
     * Get addresses.
     *
     * @param $addressable
     * @return mixed
     */
    public function getAddresses($addressable);
}