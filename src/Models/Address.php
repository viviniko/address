<?php

namespace Viviniko\Address\Models;

use Illuminate\Support\Facades\Config;
use Viviniko\Support\Database\Eloquent\Model;

class Address extends Model
{
    protected $tableConfigKey = 'address.addresses_table';

    protected $fillable = [
        'addressable_type', 'addressable_id', 'firstname', 'lastname',
        'street1', 'street2', 'city_name', 'state', 'state_name', 'country', 'country_name', 'postal_code', 'phone',
        'type', 'is_default'
    ];

    /**
     * Get all of the owning addressable model.
     */
    public function addressable()
    {
        return $this->morphTo();
    }
}