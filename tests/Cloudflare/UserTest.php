<?php
/**
 * @author Chris Hilsdon <chris@koolserve.uk>
 */
namespace Cloudflare\Tests;

use Cloudflare;

class UserTest extends BaseUnit
{
    protected function setup()
    {
        $this->newCloudflare();
        $this->User = new Cloudflare\User($this->getCloudflare());
    }

    public function testGetUserInfo()
    {
        $test = $this->User->get();
        $this->assertNotNull($test, "User info was empty");
    }
}