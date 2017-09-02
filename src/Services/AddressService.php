<?php

namespace Viviniko\Address\Services;

use Viviniko\Address\Contracts\AddressService as AddressServiceInterface;
use Viviniko\Address\Models\Address;
use Viviniko\Address\Repositories\Address\AddressRepository;
use Viviniko\Address\Repositories\Country\CountryRepository;
use Viviniko\Agent\Facades\Agent;
use Viviniko\Support\Database\Eloquent\Model;

class AddressService implements AddressServiceInterface
{
    /**
     * @var \Viviniko\Address\Repositories\Country\CountryRepository
     */
    protected $countries;

    /**
     * @var \Viviniko\Address\Repositories\Address\AddressRepository
     */
    protected $addresses;

    /**
     * AddressService constructor.
     * @param \Viviniko\Address\Repositories\Country\CountryRepository $countries
     * @param \Viviniko\Address\Repositories\Address\AddressRepository $addresses
     */
    public function __construct(CountryRepository $countries, AddressRepository $addresses)
    {
        $this->countries = $countries;
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
     * Get all countries.
     *
     * @return mixed
     */
    public function getCountries()
    {
        return $this->countries->all();
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
        $country = $this->countries->findBy('code', $location->iso_code);
        if (! $country) {
            $address->country_id = $country->id;
        } else {
            $address->country_id = data_get($this->countries->all()->first(), 'id');
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

    /**
     * Get country.
     *
     * @param $code
     * @return mixed
     */
    public function findCountryByCode($code)
    {
        return $this->countries->findByCode($code);
    }
}