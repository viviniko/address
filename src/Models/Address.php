<?php

namespace Viviniko\Address\Models;

use Viviniko\Support\Database\Eloquent\Model;

class Address extends Model
{
    protected $tableConfigKey = 'address.addresses_table';

    protected $fillable = [
        'addressable_type', 'addressable_id', 'first_name', 'last_name',
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

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getReadableAttribute()
    {
        $splices = collect([]);
        $splices->push($this->street1);
        $splices->push($this->street2);
        $splices->push($this->city_name);
        $splices->push($this->state_name);
        $splices->push($this->country_name);
        $splices->push($this->postal_code);

        return $splices->filter(function ($item) {
            return !empty($item);
        })->implode(', ');
    }
}