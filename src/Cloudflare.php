<?php
namespace Cloudflare;

use Symfony\Component\Yaml\Yaml;

class Cloudflare
{
    public $Endpoint = "https://api.cloudflare.com/client/v4/";
    public $APIKEY;
    public $Email;

    public function __construct($APIKEY = null, $Email = null)
    {
        if (is_null($APIKEY) || is_null($Email)) {
            $this->loadConfig();
        } else {
            $this->APIKEY = $APIKEY;
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

        $this->APIKEY = $config['APIKEY'];
        $this->Email = $config['Email'];
    }
}
