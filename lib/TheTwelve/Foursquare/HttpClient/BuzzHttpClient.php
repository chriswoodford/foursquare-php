<?php

namespace TheTwelve\Foursquare\HttpClient;

use Buzz\Browser;

class BuzzHttpClient extends HttpClientAdapter
{

    /** @var \Buzz\Browser */
    protected $client;

    /**
     * initialize the buzz http client
     * @param \Buzz\Browser $client
     */
    public function __construct(Browser $client)
    {

        $this->client = $client;

    }

    /**
     * (non-PHPdoc)
     * @see \TheTwelve\Foursquare.HttpClient::get()
     */
    public function get($uri, array $params = array())
    {

        $uri .= '?' . http_build_query($params);
        return $this->client->get($uri);

    }

    /**
     * (non-PHPdoc)
     * @see TheTwelve\Foursquare.HttpClient::post()
     */
    public function post($uri, array $params = array())
    {

    }

}
