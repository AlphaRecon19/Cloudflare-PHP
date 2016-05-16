<?php
namespace Cloudflare;

use Request;

class Base
{
    public $CF;

    public function __construct($Cloudflare)
    {
        $this->CF = $Cloudflare;
    }
}
