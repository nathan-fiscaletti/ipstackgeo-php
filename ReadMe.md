# IPStack for PHP (Geo Location Library)
> **IPStack for PHP** is a simple library used to interface with an IPStack Geo API.
>
> **Hint**: IPStack for PHP is available through [Composer](https://getcomposer.org). `composer require nafisc/ipstackgeo-php`.

[![Maintainability](https://api.codeclimate.com/v1/badges/2cbb563c1ef04059df2d/maintainability)](https://codeclimate.com/github/nathan-fiscaletti/ipstackgeo-php/maintainability)
[![StyleCI](https://styleci.io/repos/115560334/shield?style=flat)](https://styleci.io/repos/115560334)
[![TravisCI](https://travis-ci.com/nathan-fiscaletti/ipstackgeo-php.svg?branch=master)](https://travis-ci.com/nathan-fiscaletti/ipstackgeo-php)
[![Latest Stable Version](https://poser.pugx.org/nafisc/ipstackgeo-php/v/stable?format=flat)](https://packagist.org/packages/nafisc/ipstackgeo-php)
[![Total Downloads](https://poser.pugx.org/nafisc/ipstackgeo-php/downloads?format=flat)](https://packagist.org/packages/nafisc/ipstackgeo-php)
[![Latest Unstable Version](https://poser.pugx.org/nafisc/ipstackgeo-php/v/unstable?format=flat)](https://packagist.org/packages/nafisc/ipstackgeo-php)
[![License](https://poser.pugx.org/nafisc/ipstackgeo-php/license?format=flat)](https://packagist.org/packages/nafisc/ipstackgeo-php)

Learn more about IPStack here: [ipstack.net](https://ipstack.com/product)

### Features
* Retrieve the Geo Location data for any IP address.
* (Legacy) Link to a custom FreeGeoIP server

### Example Usage

> Note: See [Location.php](https://github.com/nathan-fiscaletti/ipstackgeo-php/blob/v1.4/src/IPStack/Location.php) for a list of available properties on the Location object.

#### Create the GeoLookup object

```php
use IPStack\PHP\GeoLookup;

$geoLookup = new GeoLookup(
    'acecac3893c90871c3', // API Key
    false,                // Use HTTPS (IPStack Basic plan and up only, defaults to false)
    10                    // Timeout in seconds (defaults to 10 seconds)
);
```

#### Lookup a location for an IP Address

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
    $location = $geoLookup->getLocation('github.com');

    // If we are unable to retrieve the location information
    // for an IP address, null will be returned.
    if (\is_null($location)) {
        echo 'Failed to find location.'.PHP_EOL;
    } else {
        // Print the Location Object.
        print_r($location);
    }
} catch (\Exception $e) {
    echo $e->getMessage();
}
```

#### Lookup IPs locations in bulk

You can also look up the location for multiple IP addresses at once.

> Note: This requires the PROFESSIONAL teir API key or higher and is limitted to 50 IPs at a time.

```php
$lookup = ['google.com', 'github.com', '1.1.1.1'];
$locations = $geoLookup->getLocations(...$lookup);
print_r($locations);
```

#### Using the the Legacy [FreeGeoIP Binary](https://github.com/fiorix/freegeoip/releases/)

You can still use the legacy FreeGeoIP Binary hosted on a server
> Note: [FreeGeoIP has been deprecated](https://github.com/apilayer/freegeoip/#freegeoip---important-announcement).

```php
use IPStack\PHP\Legacy\FreeGeoIp as GeoLookup;

// Address, Port, Protocol, Timeout
$geoLookup = new GeoLookup(
    'localhost', // Address hosting the legacy FreeGeoIP Binary
    8080,        // Port that the binary is running on (defaults to 8080)
    'http',      // Protocol to use (defaults to http)
    10           // Timeout (defaults to 10 seconds)
);
```
