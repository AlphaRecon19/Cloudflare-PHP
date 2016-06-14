<?php
/*
 * @author Chris Hilsdon <chris@koolserve.uk>
 *
 * @link https://api.cloudflare.com/#zone
 */
namespace Cloudflare;

use GuzzleHttp\Exception\ClientException;

class ZoneAnalytics extends Base
{
    protected $URL = "zones";

    /**
     *
     * @link https://api.cloudflare.com/#zone-analytics-dashboard
     */
    public function fetchDashboard($zone = '', $options = [])
    {
        $defaultOptions = [
            'since' => '-10080',
            'until' => 0,
            'continuous' => "true",
        ];

        $newOptions = [];
        $newOptions = array_merge($newOptions, $defaultOptions, $options);

        $string = "?";
        foreach ($newOptions as $k => $v) {
            $string .= $k . '=' . $v . '&';
        }

        //Remove the last '&'
        $string = substr($string, 0, -1);

        try{
            $this->makeRequest($this->URL . '/' . $zone . '/analytics/dashboard/' . $string);
        } catch (ClientException $e) {
            return false;
        }

        return $this;
    }

    public function getTotalRequests()
    {
        $response = $this->getResponse();
        return $response->result->totals->requests;
    }
}
