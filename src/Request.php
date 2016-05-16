<?php
namespace Cloudflare;

use GuzzleHttp\Client;

class Request extends Base
{
    protected $request;
    protected $response;

    public function makeRequest($request = "", $type = "GET")
    {
        $client = new Client();
        $this->request = $client->request($type, $this->CF->Endpoint . $request, [
            'headers' => [
                'X-Auth-Key' => $this->CF->APIKEY,
                'X-Auth-Email' => $this->CF->Email
            ]
        ]);

        $response = (string) $this->request->getBody();
        $this->response = @json_decode($response);

        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }
}
