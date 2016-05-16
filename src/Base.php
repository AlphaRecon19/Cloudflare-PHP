<?php
/**
 * @author Chris Hilsdon <chris@koolserve.uk>
 */
namespace Cloudflare;

class Base
{
    use Traits\Request;

    public $CF;

    public function __construct($Cloudflare)
    {
        $this->CF = $Cloudflare;
    }
}
