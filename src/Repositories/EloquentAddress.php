<?php

namespace Viviniko\Address\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Viviniko\Repository\EloquentRepository;

class EloquentAddress extends EloquentRepository implements AddressRepository
{
    public function __construct()
    {
        parent::__construct(Config::get('address.address'));
    }

    /**
     * List addresses.
     *
     * @param mixed $addressable
     * @return \Illuminate\Support\Collection
     */
    public function lists($addressable)
    {
        return $this->createQuery()->where(
            $addressable instanceof Model ? [
                'addressable_type' => $addressable->getMorphClass(),
                'addressable_id' => $addressable->id,
            ] : $addressable
        )->orderByRaw('is_default desc, created_at desc')->get();
    }
}