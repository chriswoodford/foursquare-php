<?php

namespace TheTwelve\Foursquare\HttpClient;

use Symfony\Component\HttpFoundation\RedirectResponse;

class SymfonyHttpClient extends HttpClientAdapter
{

    /**
     * (non-PHPdoc)
     * @see TheTwelve\Foursquare.HttpClient::redirect()
     */
    public function redirect($uri)
    {

        $response = new RedirectResponse($uri);
        $response->sendHeaders();
        return $response;

    }

}
