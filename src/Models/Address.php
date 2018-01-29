<?php

namespace Viviniko\Address\Models;

use Illuminate\Support\Facades\Config;
use Viviniko\Support\Database\Eloquent\Model;

class Address extends Model
{
    protected $tableConfigKey = 'address.addresses_table';

    protected $fillable = [
        'addressable_type', 'addressable_id', 'firstname', 'lastname',
        'street1', 'street2', 'city_name', 'state_name', 'country_id', 'postal_code', 'phone', 'is_default'
    ];

    public function getCountryCodeAttribute()
    {
        return data_get($this->country, 'code');
    }

    public function getCountryNameAttribute()
    {
        return data_get($this->country, 'name');
    }

    public function country()
    {
        return $this->belongsTo(Config::get('country.country'), 'country_id');
    }

    /**
     * Get all of the owning addressable model.
     */
    public function addressable()
    {
        return $this->morphTo();
    }
}