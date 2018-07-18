<?php

namespace IPStack\PHP;

use GuzzleHttp\Client;
use TixAstronauta\AccIp\AccIp;

/**
 * A PHP class for querying a FreeGeoIP server
 * for the Geo Location information of an IP.
 */
class GeoLookup
{
    /**
     * The timeout for the current server.
     *
     * @var int
     */
    private $timeout;

    /**
     * The API key used to connect to the IPStack API.
     *
     * @var string
     */
    private $api_key;

    /**
     * If set to true, HTTPS will be used for the connection.
     *
     * @var bool
     */
    private $use_https;

    /**
     * Construct the FreeGeoIp object with server information.
     * Defaults to freegeoip.net.
     *
     * @param string      $api_key
     * @param string      $server_address
     * @param int         $server_port
     * @param string      $server_protocol
     * @param int         $timeout
     */
    public function __construct(
        string $api_key,
        bool   $use_https = false,
        int    $timeout = 10
    ) {
        $this->timeout = $timeout;
        $this->api_key = $api_key;
        $this->use_https = $use_https;
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
                'base_uri' => (
                    ($this->use_https)
                        ?'https'
                        :'http'
                ).'://api.ipstack.com/',
                'timeout' => $this->timeout
            ]))->get($ip.'?access_key='.$this->api_key.'&output=json');

            if ($response->getStatusCode() == 200) {
                $compiled = json_decode($response->getBody()->getContents(), true);
                if (array_key_exists('error', $compiled)) {
                    throw new \Exception('Error: '.$compiled['error']['info']);
                }

                $ret = new Location($compiled);
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
}
