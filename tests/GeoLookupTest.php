<?php

namespace IPStack\PHP\Tests;

use PHPUnit\Framework\TestCase;
use IPStack\PHP\GeoLookup;

/**
 * @covers \IPStack\PHP\GeoLookup
 */
final class GeoLookupTest extends TestCase {
	public function testGetLocationForReturnsLocationObject()
	{
		$geo = new GeoLookup('d0164200acfaa5ad0a154d1a7398bc90');
		$location = $geo->getLocationFor('github.com');
		$this->assertInstanceOf(\IPStack\PHP\Location::class, $location);
	}
}
