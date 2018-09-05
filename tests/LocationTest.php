<?php

namespace FreeGeoIp\PHP\Tests;

use PHPUnit\Framework\TestCase;
use IPStack\PHP\Location;

/**
 * @covers \IPStack\PHP\Location
 */
final class LocationTest extends TestCase
{
    public function testIsReadOnly()
    {
        $location = new Location([
            'ip' => '127.0.0.1'
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Cannot modify a read only array.');

        $location->ip = '192.168.1.1';
    }

    public function testFillable()
    {
        // Verify that fillable property is fillable
        $location = new Location([
            'ip' => '127.0.0.1'
        ]);

        $this->assertEquals($location->ip, '127.0.0.1');

        // Verify that unfillable property is not
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Cannot initialize element \'test\' on an AssociativeArray that uses the Restricted trait. \'test\' is not fillable.');

        $location = new Location([
            'test' => 'somval'
        ]);
    }
}
