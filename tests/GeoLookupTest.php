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
		$location = $geo->getLocationFor('github.com');

		$this->assertInstanceOf(Location::class, $location);
	}

	public function testGetLocationWithHttpsForReturnsLocationObjectOnInvalidPlan()
	{
		$geo = new GeoLookup('d0164200acfaa5ad0a154d1a7398bc90', true);

		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('Error: Access Restricted - Your current Subscription Plan does not support HTTPS Encryption.');

		$location = $geo->getLocationFor('github.com');

		$this->assertInstanceOf(Location::class, $location);
	}

	public function testGetClientLocationOnUnableToFindClientIp()
	{
		$geo = new GeoLookup('d0164200acfaa5ad0a154d1a7398bc90');

		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('Error: Unable to find client IP address.');

		$location = $geo->getClientLocation('github.com');

		$this->assertInstanceOf(Location::class, $location);
	}
}
