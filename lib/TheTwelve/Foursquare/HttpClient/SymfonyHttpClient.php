<?php

namespace TheTwelve\Foursquare\HttpClient;

use Symfony\Component\HttpFoundation;

class SymfonyHttpClient extends HttpClientAdapter
{

    /**
     * (non-PHPdoc)
     * @see \TheTwelve\Foursquare.HttpClient::get()
     */
    public function get($uri, array $params = array())
    {

        $request = HttpFoundation\Request::create($uri, 'GET', $params);
        $uri = $request->getUri();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_USERAGENT, 'twelvelabs/foursquare client');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;

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

}
