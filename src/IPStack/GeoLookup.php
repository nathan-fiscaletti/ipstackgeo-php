<?php

namespace IPStack\PHP;

use GuzzleHttp\Client;
use TixAstronauta\AccIp\AccIp;

/**
 * A PHP class for querying an IPStack server
 * for the Geo Location information of an IP.
 */
class GeoLookup
{
    /**
     * The API key used to connect to the IPStack API.
     *
     * @var string
     */
    private $api_key;

    /**
     * The timeout for the current server.
     *
     * @var int
     */
    private $timeout = 10;

    /**
     * If set to true, HTTPS will be used for the connection.
     *
     * @var bool
     */
    private $use_https = false;

    /**
     * Whether or not to attempt reverse hostname lookup when
     * looking up location data.
     * 
     * @var bool
     */
    private $find_hostname = false;

    /**
     * Whether or not to assess the security of an IP address.
     * 
     * @var bool
     */
    private $assess_security = false;

    /**
     * The language to translate the response into.
     * 
     * @var string
     */
    private $language = 'en';

    /**
     * Construct the FreeGeoIp object with server information.
     * Defaults to freegeoip.net.
     *
     * @param string $api_key Your IPStack API Key.
     */
    public function __construct(string $api_key) {
        $this->api_key = $api_key;
    }

    /**
     * Retrieve a location for a specific IP address.
     *
     * @param  string $ip The IP to lookup.
     *
     * @return array|null
     * @throws \Exception
     */
    public function getLocation(string $ip)
    {
        $ret = null;

        try {
            $response = (new Client([
                'base_uri' => (
                    ($this->use_https)
                        ? 'https'
                        : 'http'
                ).'://api.ipstack.com/',
                'timeout' => $this->timeout,
            ]))->get(
                $ip.'?access_key='.$this->api_key.
                '&output=json'.
                ($this->find_hostname?'&hostname=1':'').
                ($this->assess_security?'&security=1':'').
                '&language='.$this->language
            );

            if ($response->getStatusCode() == 200) {
                $compiled = json_decode($response->getBody()->getContents(), true);
                if (array_key_exists('error', $compiled)) {
                    throw new \Exception('Error: '.$compiled['error']['info']);
                }

                $ret = $compiled;
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return $ret;
    }

    /**
     * Retrieve the location information for a batch of IP addresses.
     *
     * @param string ...$ips The IP addresses.
     *
     * @return array|null
     * @throws \Exception
     */
    public function getLocations(string ...$ips)
    {
        if (\count($ips) > 50) {
            throw new \Exception('Error: Bulk lookup limitted to 50 IP addresses at a time.');
        }

        $ret = null;

        try {
            $response = (new Client([
                'base_uri' => (
                    ($this->use_https)
                        ? 'https'
                        : 'http'
                ).'://api.ipstack.com/',
                'timeout' => $this->timeout,
            ]))->get(
                implode(',', $ips).'?access_key='.$this->api_key.
                '&output=json'.
                ($this->find_hostname?'&hostname=1':'').
                ($this->assess_security?'&security=1':'').
                '&language='.$this->language
            );

            if ($response->getStatusCode() == 200) {
                $compiled = json_decode($response->getBody()->getContents(), true);
                if (array_key_exists('error', $compiled)) {
                    throw new \Exception('Error: '.$compiled['error']['info']);
                }

                $ret = $compiled;
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return $ret;
    }

    /**
     * Retrieve the location information for the system executing this code.
     * 
     * @return array|null
     * @throws \Exception
     */
    public function getOwnLocation()
    {
        $ret = null;

        try {
            $response = (new Client([
                'base_uri' => (
                    ($this->use_https)
                        ? 'https'
                        : 'http'
                ).'://api.ipstack.com/',
                'timeout' => $this->timeout,
            ]))->get(
                'check?access_key='.$this->api_key.
                '&output=json'.
                ($this->find_hostname?'&hostname=1':'').
                ($this->assess_security?'&security=1':'').
                '&language='.$this->language
            );

            if ($response->getStatusCode() == 200) {
                $compiled = json_decode($response->getBody()->getContents(), true);
                if (array_key_exists('error', $compiled)) {
                    throw new \Exception('Error: '.$compiled['error']['info']);
                }

                $ret = $compiled;
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return $ret;
    }

    /**
     * Returns a location for the current clients IP address.
     *
     * @return \FreeGeoIp\PHP\Location
     * @throws \Exception
     */
    public function getClientLocation()
    {
        $accIp = new AccIp();
        $ip = $accIp->getIpAddress();

        if ($ip === false) {
            throw new \Exception('Error: Unable to find client IP address.');
        }

        return $this->getLocationFor($ip);
    }

    /**
     * Set whether or not to attempt reverse hostname lookup when
     * looking up location data.
     *
     * @var bool $value The new value.
     *
     * @see https://ipstack.com/documentation#hostname
     * @return \IPStack\PHP\GeoLookup
     */
    public function setFindHostname(bool $value)
    {
        $this->find_hostname = $value;

        return $this;
    }

    /**
     * Get whether or not to attempt reverse hostname lookup when
     * looking up location data.
     *
     * @return bool
     */
    public function getFindHostname()
    {
        return $this->find_hostname;
    }

    /**
     * Set whether or not to use HTTPS with this connection.
     *
     * @var bool $value The new value.
     *
     * @return \IPStack\PHP\GeoLookup
     */
    public function useHttps(bool $value)
    {
        $this->use_https = $value;

        return $this;
    }

    /**
     * Get whether or not to use HTTPS with this connection.
     *
     * @return bool
     */
    public function isUsingHttps()
    {
        return $this->use_https;
    }

    /**
     * Set whether or not to assess the security of an IP address.
     *
     * @var bool $value The new value.
     *
     * @see https://ipstack.com/documentation#security
     * @return \IPStack\PHP\GeoLookup
     */
    public function assessSecurity(bool $value)
    {
        $this->assess_security = $value;

        return $this;
    }

    /**
     * Get whether or not to assess the security of an IP address.
     *
     * @return bool
     */
    public function isAssessingSecurity()
    {
        return $this->assess_security;
    }

    /**
     * Set the timeout for connections.
     *
     * @var int $value The new value.
     *
     * @return \IPStack\PHP\GeoLookup
     */
    public function setTimeout(int $value)
    {
        $this->timeout = $value;

        return $this;
    }

    /**
     * Specify the language that the response should be translated into.
     *
     * @var int $value The new language.
     * 
     * @see https://ipstack.com/documentation#language
     * @return \IPStack\PHP\GeoLookup
     */
    public function setLanguage(string $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Retrieve the currently configured language.
     * 
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Get the timeout for connections.
     * 
     * @return int
     */
    public function getTimeout() {
        return $this->timeout;
    }
}
