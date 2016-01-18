<?php
namespace Cloudflare\User;

/*
 * @link https://api.cloudflare.com/#user-properties
 */
class User extends \Cloudflare\Base
{
    public $URL = "/user";

    public function __construct($Cloudflare)
    {
        parent::__construct($Cloudflare);
    }

    public function getDetails()
    {
        return $this->makeRequest($this->URL);
    }
}
