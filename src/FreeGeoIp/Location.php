<?php

namespace FreeGeoIp\PHP;

use ExtendedArrays\AssociativeArray as AssocArr;

class Location extends AssocArr
{
    /**
     * Fillable properties of the object.
     *
     * @var array
     */
    protected $fillable = [
        'ip',
        'country_code',
        'country_name',
        'region_code',
        'region_name',
        'city',
        'zip_code',
        'time_zone',
        'latitude',
        'longitude',
        'metro_code',
    ];
}
