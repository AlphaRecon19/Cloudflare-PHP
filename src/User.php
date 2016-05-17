<?php
/*
 * @author Chris Hilsdon <chris@koolserve.uk>
 *
 * @link https://api.cloudflare.com/#user-properties
 */
namespace Cloudflare;

class User extends Base
{
    protected $URL = "user";

    public function get()
    {
        $this->makeRequest($this->URL);

        return $this->getResponse();
    }
}
