<?php

namespace Viviniko\Address\Repositories\Country;

use Viviniko\Repository\SimpleRepository;

class EloquentCountry extends SimpleRepository implements CountryRepository
{
    protected $modelConfigKey = 'address.country';

    public function all()
    {
        return $this->search([])->get();
    }

    public function findByCode($code)
    {
        return $this->findBy('code', $code)->first();
    }
}