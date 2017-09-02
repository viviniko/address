<?php

namespace Viviniko\Address\Repositories\Address;

use Viviniko\Repository\SimpleRepository;

class EloquentAddress extends SimpleRepository implements AddressRepository
{
    protected $modelConfigKey = 'address.address';

    protected $fieldSearchable = [
        'addressable_type',
        'addressable_id',
    ];
}