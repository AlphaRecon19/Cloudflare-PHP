<?php
/**
 * @author Chris Hilsdon <chris@koolserve.uk>
 */
namespace Cloudflare\Tests;

use Cloudflare;

class ZoneAnalyticsTest extends BaseUnit
{
    protected $ZoneAnalytics;

    //koolserve.xyz
    private $KSZoneID = "0f236a513258267544b22764501c4ae6";

    protected function setup()
    {
        $this->newCloudflare();
        $this->ZoneAnalytics = new Cloudflare\ZoneAnalytics($this->getCloudflare());
    }

    public function testDashboardNoZone()
    {
        $test = $this->ZoneAnalytics->fetchDashboard();
        $this->assertFalse($test, "TODO: Cahnge me");
    }
}