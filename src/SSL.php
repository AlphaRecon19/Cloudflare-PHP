<?php
/**
* @author Chris Hilsdon <chris@koolserve.uk>
*/
namespace Cloudflare;

class SSL extends Base
{
    private $config = [
        'digest_alg' => 'sha512',
        'private_key_bits' => 4096,
        'private_key_type' => OPENSSL_KEYTYPE_RSA,
    ];

    protected $baseUrl = 'certificates';

    protected $zone;

    public function __construct(Cloudflare $cloudflare, $zone)
    {
        parent::__construct($cloudflare);
        $cfzone = new Zone($this->CF);
        $zone = $cfzone->getDetails($zone);
        $this->zone = $zone;
    }

    private function getZoneDomain()
    {
        return $this->zone->result->name;
    }

    private function getZoneId()
    {
        return $this->zone->result->id;
    }

    public function listOriginCerts()
    {
        $id = $this->getZoneId();
        $this->makeRequest($this->baseUrl . '?zone_id=' . $id, 'GET', null, true);

        $response = $this->getResponse();

        if ($response->success !== true) {
            return false;
        }

        return $response->result;
    }

    public function revokeCert($id)
    {
        $this->makeRequest($this->baseUrl . '/' . $id, 'DELETE', null, true);
        $response = $this->getResponse();

        return $response->success;
    }

    public function getNewOriginCert()
    {
        $domain = $this->getZoneDomain();
        $csr = $this->createCSR($domain);
        $cert = $this->requestNewOriginCert($csr, $domain);
        $csr['cert'] = $cert;

        return $csr;
    }

    private function requestNewOriginCert($csr, $domain)
    {
        $data = [
            'hostnames' => [
                $domain,
                '*.' . $domain
            ],
            'requested_validity' => 5475,
            'request_type' => 'origin-rsa',
            'csr' => $csr['csr']
        ];
        $this->makeRequest('certificates', 'POST', $data, true);

        $response = $this->getResponse();

        if ($response->success !== true) {
            return false;
        }

        return [
            'id' => $response->result->id,
            'certificate' => $response->result->certificate
        ];
    }

    private function createCSR($domain)
    {
        $this->domain = $domain;
        $keys = $this->generateKeys();

        $csr = openssl_csr_new(['commonName' => $domain], $privkey, $this->config);
        openssl_csr_export($csr, $csrString);

        $keys['csr'] = $csrString;;

        return $keys;
    }

    private function generateKeys()
    {
        // Create the private and public key
        $res = openssl_pkey_new($this->config);

        // Extract the private key from $res to $privKey
        openssl_pkey_export($res, $privKey);

        // Extract the public key from $res to $pubKey
        $pubKey = openssl_pkey_get_details($res);
        $pubKey = $pubKey["key"];

        return [
            'pubKey' => $pubKey,
            'privKey' => $privKey
        ];
    }
}
