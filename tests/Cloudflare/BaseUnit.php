<?php
/**
 * @author Chris Hilsdon <chris@koolserve.uk>
 */
namespace Cloudflare\Tests;

use Cloudflare;

abstract class BaseUnit extends \PHPUnit_Framework_TestCase
{
    protected $CF;

    protected function newCloudflare()
    {
        $this->CF = new Cloudflare\Cloudflare();
        return $this->getCloudflare();
    }

    protected function getCloudflare()
    {
        return $this->CF;
    }
}