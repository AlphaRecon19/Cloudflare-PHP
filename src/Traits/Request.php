<?php
/**
 * @author Chris Hilsdon <chris@koolserve.uk>
 */
namespace Cloudflare\Traits;

use GuzzleHttp\Client;

trait Request
{
    protected $request;
    protected $response;
    protected $RequestURL;
    public $CF;

    public function getRequestURL()
    {
        return $this->RequestURL;
    }

    public function setRequestURL($url)
    {
        $this->RequestURL = $url;
    }

    public function makeRequest($request = "", $type = "GET")
    {
        $this->setRequestURL($this->CF->getEndpoint() . $request);

        //Use in testing to not actualy make the request
        if ($this->CF->getMakeRequests() === false) {
            return true;
        }

        $client = new Client();

        $this->request = $client->request($type, $this->getRequestURL(), [
            'headers' => [
                'X-Auth-Key' => $this->CF->getAPIKEY(),
                'X-Auth-Email' => $this->CF->getEmail()
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
