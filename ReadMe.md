# IPStack for PHP (Geo Location Library)
> **IPStack for PHP** is a simple library used to interface with an IPStack Geo API.

```
$ composer require nafisc/ipstackgeo-php
```

[![Maintainability](https://api.codeclimate.com/v1/badges/2cbb563c1ef04059df2d/maintainability)](https://codeclimate.com/github/nathan-fiscaletti/ipstackgeo-php/maintainability)
[![StyleCI](https://styleci.io/repos/115560334/shield?style=flat)](https://styleci.io/repos/115560334)
[![TravisCI](https://travis-ci.com/nathan-fiscaletti/ipstackgeo-php.svg?branch=master)](https://travis-ci.com/nathan-fiscaletti/ipstackgeo-php)
[![Coverage Status](https://coveralls.io/repos/github/nathan-fiscaletti/ipstackgeo-php/badge.svg)](https://coveralls.io/github/nathan-fiscaletti/ipstackgeo-php)
[![Latest Stable Version](https://poser.pugx.org/nafisc/ipstackgeo-php/v/stable?format=flat)](https://packagist.org/packages/nafisc/ipstackgeo-php)
[![Total Downloads](https://poser.pugx.org/nafisc/ipstackgeo-php/downloads?format=flat)](https://packagist.org/packages/nafisc/ipstackgeo-php)
[![License](https://poser.pugx.org/nafisc/ipstackgeo-php/license?format=flat)](https://packagist.org/packages/nafisc/ipstackgeo-php)

Learn more about IPStack here: [ipstack.net](https://ipstack.com/product)

[Looking for the Python version?](https://github.com/nathan-fiscaletti/ipstackgeo-py)

### Features
* Retrieve the Geo Location data for any IP address.
* Retrieve the Geo Location data for the system executing this code.
* Retrieve the Geo Location data for a client.
* Retrieve the Geo Location data for a batch of IP addresses.
* Assess the security of an IP address.

### Legacy Features
* Link to a custom FreeGeoIP server

---

### Basic Usage

```php
$geo = new GeoLookup('.....');
$location = $geo->getLocation('github.com');
print_r($location);
```

### Example Usage

> Note: See [IPStack: Response Objects](https://ipstack.com/documentation#objects) for a list of available properties in a response object.

#### Create the GeoLookup object

```php
use IPStack\PHP\GeoLookup;

// Create the GeoLookup object using your API key.
$geoLookup = new GeoLookup('acecac3893c90871c3');
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

#### Look up a Clients location

```php
$location = $geoLookup->getClientLocation();
print_r($location);
```

#### Look up own location
```php
$location = $geoLookup->getOwnLocation();
print_r($location);
```

#### Other Features

There are also a few other useful features built into this library and the IPStack API.

1. Bulk Location Lookup

   The ipstack API also offers the ability to request data for multiple IPv4 or IPv6 addresses at the same time. This requires the PROFESSIONAL teir API key or higher and is limitted to 50 IPs at a time.
   > See: [https://ipstack.com/documentation#bulk](https://ipstack.com/documentation#bulk)

   ```php
   $lookup = ['google.com', 'github.com', '1.1.1.1'];
   $locations = $geoLookup->getLocations(...$lookup);
   print_r($locations);
   ```

2. Requesting the hostname for an IP address.

   By default, the ipstack API does not return information about the hostname the given IP address resolves to. In order to include the hostname use the following.
   > See: [https://ipstack.com/documentation#hostname](https://ipstack.com/documentation#hostname)

   ```php
   $location = $geoLookup->setFindHostname(true)->getLocation('1.1.1.1');
   echo $location['hostname'];
   ```

   ```
   one.one.one.one
   ```

3. Assessing Security

   Customers subscribed to the Professional Plus Plan may access the ipstack API's Security Module, which can be used to assess risks and threats originating from certain IP addresses before any harm can be done to a website or web application.
   > See: [https://ipstack.com/documentation#security](https://ipstack.com/documentation#security)

   ```php
   $location = $geoLookup->assessSecurity(true)->getLocation('github.com');
   ```

4. Set the language for a response

   The ipstack API is capable of delivering its result set in different languages. To request data in a language other than English (default) use following with one of the supported language codes.
   > See: [https://ipstack.com/documentation#language](https://ipstack.com/documentation#language)

   [Supported Langauges](https://ipstack.com/documentation#language)

   ```php
   $location = $geoLookup->setLanguage('en')->getLocation('github.com');
   ```

5. Configuring your request

   ```php
   /// Use HTTPS
   /// This requires IPStack Basic plan or higher.
   $location = $geoLookup->useHttps(true)->getLocation('github.com');

   /// Configure the timeout for requests
   $location = $geoLookup->setTimeout(15)->getLocation('github.com');
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
