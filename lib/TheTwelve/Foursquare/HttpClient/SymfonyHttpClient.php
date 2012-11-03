<?php

namespace TheTwelve\Foursquare\HttpClient;

use Symfony\Component\HttpFoundation;

class SymfonyHttpClient extends HttpClientAdapter
{

    /**
     * (non-PHPdoc)
     * @see TheTwelve\Foursquare.HttpClient::get()
     */
    public function get($uri, array $params = array())
    {

        $request = HttpFoundation\Request::create($uri, 'GET', $params);
        $uri = $request->getUri();

        return file_get_contents($uri);

    }

    /**
     * (non-PHPdoc)
     * @see TheTwelve\Foursquare.HttpClient::redirect()
     */
    public function redirect($uri)
    {

        $response = new HttpFoundation\RedirectResponse($uri);
        $response->sendHeaders();
        return $response;

    }

}
