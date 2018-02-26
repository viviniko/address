<?php

namespace Viviniko\Address\Services;

use Viviniko\Address\Contracts\AddressService as AddressServiceInterface;
use Viviniko\Address\Models\Address;
use Viviniko\Address\Repositories\Address\AddressRepository;
use Viviniko\Agent\Facades\Agent;
use Viviniko\Country\Contracts\CountryService;
use Viviniko\Support\Database\Eloquent\Model;

class AddressServiceImpl implements AddressServiceInterface
{
    /**
     * @var \Viviniko\Country\Contracts\CountryService
     */
    protected $countryService;

    /**
     * @var \Viviniko\Address\Repositories\Address\AddressRepository
     */
    protected $addresses;

    /**
     * AddressService constructor.
     * @param \Viviniko\Country\Contracts\CountryService $countryService
     * @param \Viviniko\Address\Repositories\Address\AddressRepository $addresses
     */
    public function __construct(CountryService $countryService, AddressRepository $addresses)
    {
        $this->countryService = $countryService;
        $this->addresses = $addresses;
    }

    /**
     * Paginate addresses.
     *
     * @param mixed $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function search($query)
    {
        return $this->addresses->search($query);
    }

    public function find($id)
    {
        return $this->addresses->find($id);
    }

    /**
     * Save a new address in repository
     *
     * @param array $data
     * @param Model $addressable
     *
     * @return mixed
     */
    public function create($addressable, array $data)
    {
        return $this->addresses->create(array_merge([
            'is_default' => false,
            'addressable_type' => $addressable->getMorphClass(),
            'addressable_id' => $addressable->id,
        ], $data));
    }

    /**
     * Update a address in repository by id
     *
     * @param       $id
     * @param array $data
     *
     * @return mixed
     */
    public function update($id, array $data)
    {
        return $this->addresses->update($id, $data);
    }

    /**
     * Delete a address in repository by id
     *
     * @param $id
     *
     * @return int
     */
    public function delete($id)
    {
        return $this->addresses->delete($id);
    }

    /**
     * Save a new address in repository
     *
     * @param array $data
     * @param Model $addressable
     *
     * @return mixed
     */
    public function createIfNotExists($addressable, array $data)
    {
        return $this->getExistsAddress($addressable, $data) ?? $this->create($addressable, $data);
    }

    /**
     * Get exists address.
     *
     * @param $addressable
     * @param array $data
     * @return mixed
     */
    public function getExistsAddress($addressable, array $data)
    {
        $address = null;
        $this->addresses->lists($addressable)->each(function ($item) use (&$address, $data) {
            unset($data['is_default'], $data['addressable_type'], $data['addressable_id']);
            foreach ($data as $column => $value) {
                if ($column == 'country_id') {
                    $value = (int) $value;
                }
                if (in_array($column, $item->getFillable()) && $item->$column != $value) {
                    return ; // continue each loop
                }
            }
            $address = $item;
            return false; // break each loop
        });

        return $address;
    }

    /**
     * Get default address.
     *
     * @param Model $addressable
     * @return mixed
     */
    public function getDefaultAddress($addressable)
    {
        return $this->addresses->findBy([
            'addressable_type' => $addressable->getMorphClass(),
            'addressable_id' => $addressable->id,
            'is_default' => true,
        ])->first();
    }

    /**
     * Guess client address.
     *
     * @return mixed
     */
    public function guessClientAddress()
    {
        $address = new Address();
        $location = Agent::location();
        $country = $this->countryService->findByCode($location->iso_code);
        if ($country) {
            $address->country_id = $country->id;
        } else {
            $address->country_id = data_get($this->countryService->getCountries()->first(), 'id');
        }

        return $address;
    }

    /**
     * Has default address.
     *
     * @param Model $addressable
     * @return mixed
     */
    public function hasDefaultAddress($addressable)
    {
        return $this->addresses->exists([
            'addressable_type' => $addressable->getMorphClass(),
            'addressable_id' => $addressable->id,
            'is_default' => true,
        ]);
    }

    /**
     * Has default address.
     *
     * @param Model $addressable
     * @param int|Address $address
     * @return mixed
     */
    public function setDefaultAddress($addressable, $address)
    {
        $address = $address instanceof Address ? $address->id : $address;
        if ($default = $this->getDefaultAddress($addressable)) {
            if ($default->id == $address) {
                return $default;
            }
            $this->addresses->update($default->id, ['is_default' => false]);
        }

        return $this->addresses->update($address, [
            'addressable_type' => $addressable->getMorphClass(),
            'addressable_id' => $addressable->id,
            'is_default' => true
        ]);
    }
}