<?php

namespace TheTwelve\Foursquare\HttpClient;

use Symfony\Component\HttpFoundation;

class SymfonyHttpClient extends HttpClientAdapter
{

    /**
     * set to false to stop cURL from verifying the peer's certificate
     * @var boolean
     */
    protected $verifyPeer = true;

    /**
     * set to 1 to check the existence of a common name in the SSL peer
     * certificate
     * set to 2 to check the existence of a common name and also verify
     * that it matches the hostname provided.
     * In production environments the value of this option should
     * be kept at 2 (default value).
     * @var integer
     */
    protected $verifyHost = 2;

    /**
     * update the verify peer property
     * @param boolean $value
     */
    public function setVerifyPeer($value)
    {

        $this->verifyPeer = (bool) $value;

    }

    /**
     * update the value for the verify host property
     * @param boolean $value
     */
    public function setVerifyHost($value)
    {

        $this->verifyHost = $value;

    }

    /**
     * (non-PHPdoc)
     * @see \TheTwelve\Foursquare.HttpClient::get()
     */
    public function get($uri, array $params = array())
    {

        $request = HttpFoundation\Request::create($uri, 'GET', $params);
        $uri = $request->getUri();

        $ch = $this->initCurlHandler($uri);
        return $this->makeRequest($ch);

    }

    /**
     * (non-PHPdoc)
     * @see \TheTwelve\Foursquare.HttpClient::post()
     */
    public function post($uri, array $params = array())
    {

        $request = HttpFoundation\Request::create($uri, 'POST');
        $uri = $request->getUri();

        $ch = $this->initCurlHandler($uri);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

        return $this->makeRequest($ch);

    }

    /**
     * (non-PHPdoc)
     * @see \TheTwelve\Foursquare.HttpClient::redirect()
     */
    public function redirect($uri)
    {

        $response = new HttpFoundation\RedirectResponse($uri);
        $response->sendHeaders();
        return $response;

    }

    /**
     * initialize the cURL handler
     * @param string $uri
     * @return resource
     */
    protected function initCurlHandler($uri)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_USERAGENT, 'twelvelabs/foursquare-php client');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $this->verifyHost);

        if ($this->verifyPeer === false) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }

        return $ch;

    }

    /**
     * make the cURL request
     * @param resource $ch
     * @return mixed
     */
    protected function makeRequest($ch)
    {

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;

    }

}
