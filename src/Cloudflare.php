<?php
/**
 * @author Chris Hilsdon <chris@koolserve.uk>
 */
namespace Cloudflare;

use Symfony\Component\Yaml\Yaml;
use GuzzleHttp\Client;

class Cloudflare
{
    protected $Endpoint = "https://api.cloudflare.com/client/v4/";
    protected $APIKey;
    protected $Email;
    protected $MakeRequests = true;
    protected $Guzzle;

    public function setGuzzle($Guzzle)
    {
        $this->Guzzle = $Guzzle;
    }

    public function getEndpoint()
    {
        return $this->Endpoint;
    }

    public function getAPIKey()
    {
        return $this->APIKey;
    }

    public function getEmail()
    {
        return $this->Email;
    }

    public function getMakeRequests()
    {
        return $this->MakeRequests;
    }

    public function getGuzzle()
    {
        //If Guzzle has not been setup yet
        if($this->Guzzle === null) {
            var_dump('Guzzle was created');
            $Guzzle = new Client();
            $this->setGuzzle($Guzzle);
        }

        return $this->Guzzle;
    }

    public function diableRequests()
    {
        $this->MakeRequests = false;
    }

    public function enableRequests()
    {
        $this->MakeRequests = true;
    }

    public function __construct($options = null, $Guzzle = null)
    {
        if (is_null($options) || !is_array($options)) {
            $this->loadConfig();
        } else {
            $this->APIKey = $options['APIKey'];
            $this->Email = $options['Email'];
        }

        if (!is_null($Guzzle)) {
            $this->setGuzzle($Guzzle);
        }

    }

    private function loadConfig()
    {
        $config = 'Cloudflare.yml';
        $configDist = $config.'.dist';
        $dir = $_SERVER['DOCUMENT_ROOT'];

        if (@file_exists($dir . $config)) {
            $load = $config;
        } elseif (@file_exists($dir . $configDist)) {
            $load = $configDist;
        } else {
            die('Unable to load either "'.$config.'" or "'.$configDist.'"');
        }

        $config = Yaml::parse(file_get_contents($load));

        $this->APIKey = $config['APIKey'];
        $this->Email = $config['Email'];
    }
}
