<?php
namespace Cloudflare;

use GuzzleHttp\Client;

class Base
{
    public $request;

    protected function __construct($Cloudflare)
    {
        $this->CF = $Cloudflare;
    }

    public function makeRequest($request = "", $type = "GET")
    {
        $client = new Client();
        $_request = $client->request($type, $this->CF->Endpoint . $request, [
            'headers' => [
                'X-Auth-Key' => $this->CF->APIKEY,
                'X-Auth-Email' => $this->CF->Email
            ]
        ]);

        $this->response = $this->__toArray((string) $_request->getBody());

        return $this->response;
    }

    public function __toArray($data)
    {
        return @json_decode($data);
    }
}
