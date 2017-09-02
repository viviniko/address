<?php

namespace Viviniko\Address\Models;

use Viviniko\Support\Database\Eloquent\Model;

class Country extends Model
{
    public $timestamps = false;

    protected $tableConfigKey = 'address.countries_table';

    protected $fillable = [
        'name', 'code',
    ];
}