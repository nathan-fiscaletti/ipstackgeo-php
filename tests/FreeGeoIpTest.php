<?php

namespace FreeGeoIp\PHP\Tests;

use PHPUnit\Framework\TestCase;
use FreeGeoIp\PHP\FreeGeoIp;

/**
 * @covers \FreeGeoIp\PHP\FreeGeoIp
 */
final class FreeGeoIpTest extends TestCase {
	public function testGetLocationForReturnsLocationObject()
	{
		$geo = new FreeGeoIp();
		$location = $geo->getLocationFor('github.com');
		$this->assertInstanceOf(\FreeGeoIp\PHP\Location::class, $location);
	}
}
