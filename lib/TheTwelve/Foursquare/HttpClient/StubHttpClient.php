<?php

namespace TheTwelve\Foursquare\HttpClient;

class StubHttpClient extends HttpClientAdapter
{

    /** @var mixed */
    protected $expectedResponse;

    /**
     * set the expected response
     * @param mixed $response
     */
    public function setExpectedResponse($response)
    {

        $this->expectedResponse = $response;

    }

    /**
     * (non-PHPdoc)
     * @see TheTwelve\Foursquare.HttpClient::get()
     */
    public function get($uri, array $params = array())
    {

        return $this->expectedResponse;

    }

    /**
     * (non-PHPdoc)
     * @see TheTwelve\Foursquare.HttpClient::redirect()
     */
    public function redirect($uri)
    {


    }

}
