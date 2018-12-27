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

### License

***Available Under the MIT License***

>Copyright (c) 2017-2018 Nathan Fiscaletti
>                    
>Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
                    
>The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
                    
>THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
