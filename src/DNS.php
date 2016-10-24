<?php
/*
 * @author Chris Hilsdon <chris@koolserve.uk>
 *
 * @link https://api.cloudflare.com/#zone
 */
namespace Cloudflare;

class DNS extends Base
{
    protected $URL = "zones/%s/dns_records";
    protected $zone;

    public function __construct($cloudflare, $zone)
    {
        parent::__construct($cloudflare);
        $this->zone = $zone;
    }

    /*
     *
     * @link https://api.cloudflare.com/#zone-list-zones
     */
    public function fetch()
    {
        $this->makeRequest($this->getURL());
        $response = $this->getResponse();

        if($response->success != true) {
            return false;
        }

        return $response->result;
    }

    private function getURL()
    {
        return sprintf($this->URL, $this->zone);
    }
}
