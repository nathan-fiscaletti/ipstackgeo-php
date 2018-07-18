<?php

namespace IPStack\PHP\Legacy;

use GuzzleHttp\Client;
use IPStack\PHP\Location;
use TixAstronauta\AccIp\AccIp;

/**
 * A PHP class for querying a FreeGeoIP server
 * for the Geo Location information of an IP.
 */
class FreeGeoIp
{
    /**
     * The URL for the current server.
     *
     * @var string
     */
    private $server_url;

    /**
     * The timeout for the current server.
     *
     * @var int
     */
    private $timeout;

    /**
     * Construct the FreeGeoIp object with server information.
     * Defaults to freegeoip.net.
     *
     * @param string      $server_address
     * @param int         $server_port
     * @param string      $server_protocol
     * @param int         $timeout
     */
    public function __construct(
        string $server_address,
        int    $server_port = 8080,
        string $server_protocol = 'http',
        int    $timeout = 10
    ) {
        $this->server_url = $server_protocol.'://'
        .$server_address.':'.$server_port.'/';
        $this->timeout = $timeout;
    }
    /**
     * Retrieve a location for a specific IP address.
     *
     * @param  string $ip
     *
     * @return \FreeGeoIp\PHP\Location|null
     * @throws \Exception
     */
    public function getLocationFor(string $ip)
    {
        $ret = null;
        try {
            $response = (new Client([
                'base_uri' => $this->server_url,
                'timeout' => $this->timeout,
            ]))->get('json/'.$ip);
            if ($response->getStatusCode() == 200) {
                $ret = new Location(json_decode(
                    $response->getBody()->getContents(), true));
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
            throw new \Exception('Unable to find client IP address.');
        }
        return $this->getLocationFor($ip);
    }
}