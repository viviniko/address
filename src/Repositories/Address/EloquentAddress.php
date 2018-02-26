<?php

namespace Viviniko\Address\Repositories\Address;

use Illuminate\Database\Eloquent\Model;
use Viviniko\Repository\SimpleRepository;

class EloquentAddress extends SimpleRepository implements AddressRepository
{
    protected $modelConfigKey = 'address.address';

    protected $fieldSearchable = [
        'addressable_type',
        'addressable_id',
    ];

    /**
     * List addresses.
     *
     * @param mixed $addressable
     * @return \Illuminate\Support\Collection
     */
    public function lists($addressable)
    {
        return $this->createModel()->newQuery()->where(
            $addressable instanceof Model ? [
                'addressable_type' => $addressable->getMorphClass(),
                'addressable_id' => $addressable->id,
            ] : $addressable
        )->orderByRaw('is_default desc, created_at desc')->get();
    }
}