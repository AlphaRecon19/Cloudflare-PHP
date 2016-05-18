<?php
/**
 * @author Chris Hilsdon <chris@koolserve.uk>
 */
namespace Cloudflare\Tests;

use Cloudflare;

class ZoneTest extends BaseUnit
{
    protected $Zone;

    protected function setup()
    {
        $this->newCloudflare();
        $this->Zone = new Cloudflare\Zone($this->getCloudflare());
    }

    public function testGetAllZones()
    {
        $test = $this->Zone->getAll();
        $this->assertNotNull($test, "Zone info was empty");
    }

    public function testChangeOptions()
    {
        //Disable the curl request as we are only checking the URL
        $CF = $this->getCloudflare();
        $CF->diableRequests();

        $options = [
            'status' => 'pending',
            'page' => 2,
            'per_page' => 50,
            'order' => 'name',
            'direction' => 'desc',
            'match' => 'any',
        ];
        $domain = 'test.com';

        $this->Zone->get('test.com', $options);
        $RequestURL = $this->Zone->getRequestURL();
        $this->assertNotNull($RequestURL, "Request URL was null");

        $sting = explode('zones?', $RequestURL)[1];

        $shouldBe = "name=" . $domain
            . "&status=" . $options['status']
            . "&page=" . $options['page']
            . "&per_page=" . $options['per_page']
            . "&order=" . $options['order']
            . "&direction=" . $options['direction']
            . "&match=". $options['match'];

        $this->assertSame($sting, $shouldBe, 'Request URL is not correct');
    }
}