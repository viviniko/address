<?php

namespace Viviniko\Address\Repositories\Country;

interface CountryRepository
{
    public function all();

    public function findByCode($code);
}