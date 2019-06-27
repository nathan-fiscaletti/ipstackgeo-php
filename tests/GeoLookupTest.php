<?php

namespace IPStack\PHP\Tests;

use PHPUnit\Framework\TestCase;
use IPStack\PHP\GeoLookup;
use IPStack\PHP\Location;

/**
 * @covers \IPStack\PHP\GeoLookup
 */
final class GeoLookupTest extends TestCase
{
	public function testGetLocationForReturnsLocationObject()
	{
		$geo = new GeoLookup('d0164200acfaa5ad0a154d1a7398bc90');
		$location = $geo->getLocation('github.com');

		$this->assertInternalType('array', $location);
	}

	public function testGetLocationWithHttpsForReturnsLocationObjectOnInvalidPlan()
	{
		$geo = new GeoLookup('d0164200acfaa5ad0a154d1a7398bc90', true);

		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('Error: Access Restricted - Your current Subscription Plan does not support HTTPS Encryption.');

		$location = $geo->getLocation('github.com');

		$this->assertInternalType('array', $location);
	}

	public function testGetClientLocationOnUnableToFindClientIp()
	{
		$geo = new GeoLookup('d0164200acfaa5ad0a154d1a7398bc90');

		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('Error: Unable to find client IP address.');

		$location = $geo->getClientLocation();

		$this->assertInstanceOf(Location::class, $location);
    }

    public function testGetLocationsBulkRequestReturnsErrorOnMissingAPIPermissions()
    {
        $geo = new GeoLookup('d0164200acfaa5ad0a154d1a7398bc90');

        $this->expectException(\Exception::class);
        $this->expectExceptionmessage('Error: Bulk requests are not supported on your plan. Please upgrade your subscription.');

        $location = $geo->getLocations('1.1.1.1', '2.2.2.2');

        $this->assertInternalType('array', $location);
    }

    public function testGetLocationsBulkRequestReturnsExceptionOnMoreThan50IPs()
    {
        $geo = new GeoLookup('d0164200acfaa5ad0a154d1a7398bc90');

        $this->expectException(\Exception::class);
        $this->expectExceptionmessage('Error: Bulk lookup limitted to 50 IP addresses at a time.');

        $input = [];
        $count = 51;
        while ($count--) {
            $input[] = '1.1.1.1';
        }
        $location = $geo->getLocations(...$input);
    }

    public function testGetOwnLocationReturnsArray()
    {
        $geo = new GeoLookup('d0164200acfaa5ad0a154d1a7398bc90');

		$location = $geo->getOwnLocation();

		$this->assertInternalType('array', $location);
    }
}
