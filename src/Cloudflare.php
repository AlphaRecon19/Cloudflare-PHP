<?php
/**
 * @author Chris Hilsdon <chris@koolserve.uk>
 */
namespace Cloudflare;

use Symfony\Component\Yaml\Yaml;

class Cloudflare
{
    protected $Endpoint = "https://api.cloudflare.com/client/v4/";
    protected $APIKey;
    protected $Email;
    protected $MakeRequests = true;

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

    public function diableRequests()
    {
        $this->MakeRequests = false;
    }

    public function enableRequests()
    {
        $this->MakeRequests = true;
    }

    public function __construct($APIKey = null, $Email = null)
    {
        if (is_null($APIKey) || is_null($Email)) {
            $this->loadConfig();
        } else {
            $this->APIKey = $APIKey;
            $this->Email = $Email;
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
