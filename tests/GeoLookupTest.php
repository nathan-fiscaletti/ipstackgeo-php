<?php

namespace IPStack\PHP\Tests;

use PHPUnit\Framework\TestCase;
use IPStack\PHP\GeoLookup;
use IPStack\PHP\Legacy\FreeGeoIp;

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
		$geo = new GeoLookup('d0164200acfaa5ad0a154d1a7398bc90');

		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('Error: Access Restricted - Your current Subscription Plan does not support HTTPS Encryption.');

		$location = $geo->useHttps(true)->getLocation('github.com');

		$this->assertInternalType('array', $location);
	}

	public function testGetClientLocationOnUnableToFindClientIp()
	{
		$geo = new GeoLookup('d0164200acfaa5ad0a154d1a7398bc90');

		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('Error: Unable to find client IP address.');

		$location = $geo->getClientLocation();
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

    public function testSetAndGetFindHostName()
    {
        $geo = new GeoLookup('d0164200acfaa5ad0a154d1a7398bc90');

        $geo->setFindHostname(true);

        $this->assertEquals($geo->getFindHostname(), true);

        $geo->setFindHostname(false);

        $this->assertEquals($geo->getFindHostname(), false);
    }

    public function testSetFindHostNameReturnsGeoLookup()
    {
        $geo = new GeoLookup('d0164200acfaa5ad0a154d1a7398bc90');

        $result = $geo->setFindHostname(true);

        $this->assertInstanceOf(GeoLookup::class, $result);
    }

    public function testSetAndGetUseHttps()
    {
        $geo = new GeoLookup('d0164200acfaa5ad0a154d1a7398bc90');

        $geo->useHttps(true);

        $this->assertEquals($geo->isUsingHttps(), true);

        $geo->useHttps(false);

        $this->assertEquals($geo->isUsingHttps(), false);
    }

    public function testSetUseHttpsReturnsGeoLookup()
    {
        $geo = new GeoLookup('d0164200acfaa5ad0a154d1a7398bc90');

        $result = $geo->useHttps(true);

        $this->assertInstanceOf(GeoLookup::class, $result);
    }

    public function testSetAndGetAssessSecurity()
    {
        $geo = new GeoLookup('d0164200acfaa5ad0a154d1a7398bc90');

        $geo->assessSecurity(true);

        $this->assertEquals($geo->isAssessingSecurity(), true);

        $geo->assessSecurity(false);

        $this->assertEquals($geo->isAssessingSecurity(), false);
    }

    public function testSetAssessSecurityReturnsGeoLookup()
    {
        $geo = new GeoLookup('d0164200acfaa5ad0a154d1a7398bc90');

        $result = $geo->assessSecurity(true);

        $this->assertInstanceOf(GeoLookup::class, $result);
    }

    public function testSetAndGetTimeout()
    {
        $geo = new GeoLookup('d0164200acfaa5ad0a154d1a7398bc90');

        $geo->setTimeout(true);

        $this->assertEquals($geo->getTimeout(), true);

        $geo->setTimeout(false);

        $this->assertEquals($geo->getTimeout(), false);
    }

    public function testSetTimeoutReturnsGeoLookup()
    {
        $geo = new GeoLookup('d0164200acfaa5ad0a154d1a7398bc90');

        $result = $geo->setTimeout(true);

        $this->assertInstanceOf(GeoLookup::class, $result);
    }

    public function testSetAndGetLanguage()
    {
        $geo = new GeoLookup('d0164200acfaa5ad0a154d1a7398bc90');

        $geo->setLanguage('en');

        $this->assertEquals($geo->getLanguage(), 'en');

        $geo->setLanguage('test');

        $this->assertEquals($geo->getLanguage(), 'test');
    }

    public function testSetLanguageReturnsGeoLookup()
    {
        $geo = new GeoLookup('d0164200acfaa5ad0a154d1a7398bc90');

        $result = $geo->setLanguage('en');

        $this->assertInstanceOf(GeoLookup::class, $result);
    }

    public function testLegacyConstructor()
    {
        $freeGeoIp = new FreeGeoIp(
            '127.0.0.1',
            8081,
            'https',
            11
        );

        $this->assertEquals($freeGeoIp->getServerUrl(), 'https://127.0.0.1:8081/');
        $this->assertEquals($freeGeoIp->getTimeout(), 11);
    }
}
