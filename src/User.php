<?php
namespace Cloudflare;

/*
 * @link https://api.cloudflare.com/#user-properties
 */
class User extends Base
{
    protected $URL = "/user";

    public function get()
    {
        $request = new Request($this->CF);
        $request->makeRequest($this->URL);

        return $request->getResponse();
    }
}
