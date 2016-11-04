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
        $this->makeRequest($this->getURL($this->URL));
        $response = $this->getResponse();

        if($response->success != true) {
            return false;
        }

        return $response->result;
    }

    public function getInfo($id)
    {
        $url = "zones/%s/dns_records/" . $id;
        $this->makeRequest($this->getURL($url));
        $response = $this->getResponse();

        if($response->success != true) {
            return false;
        }

        return $response->result;
    }

    /**
     * @link https://api.cloudflare.com/#dns-records-for-a-zone-create-dns-record
     */
    public function new($type, $name, $content, $ttl = 1)
    {
        $data = [
            'type' => $type,
            'name' => $name,
            'content' => $content,
            'ttl' => $ttl
        ];

        $url = $this->getURL($this->URL) . '/';
        try {
            $this->makeRequest($url, 'POST', $data);
        } catch(\Exception $e) {
            //var_dump($e);
        }
        $response = $this->getResponse();

        if($response->success != true) {
            return false;
        }

        return $response->result;
    }

    public function update($id, $value)
    {
        $info = $this->getInfo($id);
        $data = json_decode(json_encode($info), true);
        $data['content'] = $value;

        $url = $this->getURL($this->URL) . '/' . $id;
        try {
            $this->makeRequest($url, 'PUT', $data);
        } catch(\Exception $e) {
            //var_dump($e);
        }
        $response = $this->getResponse();

        if($response->success != true) {
            return false;
        }

        return $response->result;
    }

    public function delete($id)
    {
        $url = $this->getURL($this->URL) . '/' . $id;
        try {
            $this->makeRequest($url, 'DELETE');
        } catch(\Exception $e) {
            //var_dump($e);
        }

        $response = $this->getResponse();

        if($response->success === true) {
            return true;
        }

        return false;
    }

    private function getURL($url)
    {
        return sprintf($url, $this->zone);
    }
}
