<?php

namespace TheTwelve\Foursquare\HttpClient;

use Symfony\Component\HttpFoundation;

class SymfonyHttpClient extends CurlHttpClient
{

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

}
