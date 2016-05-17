<?php
/*
 * @author Chris Hilsdon <chris@koolserve.uk>
 *
 * @link https://api.cloudflare.com/#zone
 */
namespace Cloudflare;

class Zone extends Base
{
    protected $URL = "zones";

    /**
     *
     * @link https://api.cloudflare.com/#zone-list-zones
     */
    public function getAll()
    {
        $this->makeRequest($this->URL);
        return $this->getResponse();
    }

    /**
     *
     * @link https://api.cloudflare.com/#zone-list-zones
     */
    public function get($name = '', $options = [])
    {
        $defaultOptions = [
            'status' => 'active',
            'page' => 1,
            'per_page' => 20,
            'order' => 'status',
            'direction' => 'asc',
            'match' => 'all',
        ];

        $newOptions = [
            'name' => $name
        ];

        $newOptions = array_merge($newOptions, $defaultOptions, $options);

        $string = "?";
        foreach ($newOptions as $k => $v) {
            $string .= $k . '=' . $v . '&';
        }

        //Remove the last '&'
        $string = substr($string, 0, -1);

        $this->makeRequest($this->URL . $string);
        return $this->getResponse();
    }
}
