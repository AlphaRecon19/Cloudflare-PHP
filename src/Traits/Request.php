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

    public function makeRequest($request = "", $type = "GET", $data = null, $isCA = false)
    {
        $this->setRequestURL($this->CF->getEndpoint() . $request);

        //Use in testing to not actualy make the request
        if ($this->CF->getMakeRequests() === false) {
            return true;
        }

        $client = new Client();

        $headers = [
            'X-Auth-Key' => $this->CF->getAPIKEY(),
            'X-Auth-Email' => $this->CF->getEmail()
        ];

        if ($isCA === true) {
            $headers = [
                'X-Auth-User-Service-Key' => $this->CF->getOriginCAKey()
            ];
        }

        $this->request = $client->request($type, $this->getRequestURL(), [
            'headers' => $headers,
            'json' => $data
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
