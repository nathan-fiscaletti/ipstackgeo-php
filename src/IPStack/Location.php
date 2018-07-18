<?php

namespace IPStack\PHP;

use ExtendedArrays\ReadOnlyRestrictedAssociativeArray as ReadOnlyResAssocArr;

class Location extends ReadOnlyResAssocArr
{
    /**
     * Fillable properties of the object.
     *
     * @var array
     */
    protected $fillable = [

        // These properties are available on all 
        // IPStack plans.
        'ip',
        'type',
        'continent_code',
        'continent_name',
        'country_code',
        'country_name',
        'region_code',
        'region_name',
        'city',
        'zip',
        'latitude',
        'longitude',
        'location',

        // These properties require an API
        // key with IPStack's Basic plan or higher.
        // Free plans will not have access to them.
        'time_zone',
        'connection',
        'currency',

        // This property requires an API
        // key with IPStack's Enterprise plan
        // Other API keys will not have access to it.
        'security',

        // These properties are used when you are
        // using the legacy FreeGeoIp binary.
        'zip_code',
        'metro_code'
    ];
}
