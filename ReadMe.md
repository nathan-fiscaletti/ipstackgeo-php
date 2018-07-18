# IPStack for PHP (Geo Location Library)
> **IPStack for PHP** is a simple library used to interface with an IPStack Geo API.
>
> **Hint**: IPStack for PHP is available through [Composer](https://getcomposer.org). `composer require nafisc/ipstackgeo-php`.

[![StyleCI](https://styleci.io/repos/115560334/shield?style=flat)](https://styleci.io/repos/115560334)
[![TravisCI](https://travis-ci.com/nathan-fiscaletti/ipstackgeo-php.svg?branch=master)](https://travis-ci.com/nathan-fiscaletti/ipstackgeo-php)
[![Latest Stable Version](https://poser.pugx.org/nafisc/ipstackgeo-php/v/stable?format=flat)](https://packagist.org/packages/nafisc/ipstackgeo-php)
[![Total Downloads](https://poser.pugx.org/nafisc/ipstackgeo-php/downloads?format=flat)](https://packagist.org/packages/nafisc/ipstackgeo-php)
[![Latest Unstable Version](https://poser.pugx.org/nafisc/ipstackgeo-php/v/unstable?format=flat)](https://packagist.org/packages/nafisc/ipstackgeo-php)
[![License](https://poser.pugx.org/nafisc/ipstackgeo-php/license?format=flat)](https://packagist.org/packages/nafisc/ipstackgeo-php)

Learn more about IPStack here: [ipstack.net](https://ipstack.com/product)

### Features
* Retrieve the Geo Location data for any IP address.
* Link to a custom ipstack server

### Example Usage

#### Include the `GeoLookup` class in your code.
```php
use IPStack\PHP\GeoLookup;
```

#### Create the GeoLookup object

```php
// Initialize with your IPStack API Key.
$geoLookup = new GeoLookup(
    'acecac3893c90871c3', // API Key
    false,                // Use HTTPS (IPStack Basic plan and up only, defaults to false)
    10                    // Timeout in seconds (defaults to 10 seconds)
);
```

#### Using the the Legacy [FreeGeoIP Binary](https://github.com/fiorix/freegeoip/releases/)

You can still use the legacy FreeGeoIP Binary hosted on a server
> Note: [FreeGeoIP has been deprecated](https://github.com/apilayer/freegeoip/#freegeoip---important-announcement).

```php
use IPStack\Legacy\FreeGeoIp as GeoLookup;

// Address, Port, Protocol, Timeout
$geoLookup = new GeoLookup(
    'localhost', // Address hosting the legacy FreeGeoIP Binary
    8080,        // Port that the binary is running on (defaults to 8080)
    'http',      // Protocol to use (defaults to http)
    10           // Timeout (defaults to 10 seconds)
);
```

#### Lookup a location for an IP Address

> Note: Locations are returned using a library called ExtendedArrays.
> This library gives us more options on how we access the properties of the location.
> See the [Acessing Array Elements](https://github.com/nathan-fiscaletti/extended-arrays/blob/master/Examples/Managing%20Arrays.md#accessing-array-elements) portion of the ExtendedArrays documentation for more information on this.

```php
// Lookup a location for an IP Address
// and catch any exceptions that might
// be thrown by Guzzle or IPStack.
try {
    // Retrieve the location information for 
    // github.com by using it's hostname.
    // 
    // This function will work with hostnames
    // or IP addresses.
    $location = $geoLookup->getLocationFor('github.com');

    // You can alternately look up the information
    // for the current client's IP address.
    $location = $geoLookup->getClientLocation();

    // If we are unable to retrieve the location information
    // for an IP address, null will be returned.
    if ($location == null) {
        echo 'Failed to find location.'.PHP_EOL;
    } else {
        // Convert the location to a standard PHP array.
        print_r($location->_asStdArray());

        // Any of these formats will work for 
        // retrieving a property.
        echo $location->latitude . PHP_EOL;
        echo $location['longitude'] . PHP_EOL;
        echo $location->region_name() . PHP_EOL;
    }
} catch (\Exception $e) {
    echo $e->getMessage();
}
```

> Note: See [Location.php](https://github.com/nathan-fiscaletti/ipstackgeo-php/blob/v1.3/src/IPStack/Location.php) for a list of available properties on the Location object.
