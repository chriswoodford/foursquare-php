<?php

namespace TheTwelve\Foursquare;

abstract class Gateway
{

    /** @var TheTwelve\Foursquare\HttpClient */
    protected $client;

    /** @var string */
    protected $token;

    /**
     * initialize the gateway
     * @param TheTwelve\Foursquare\HttpClient;
     */
    public function __construct(HttpClient $client)
    {

        $this->client = $client;

    }

    /**
     * set the auth token
     * @param string $token
     */
    public function setToken($token)
    {

        $this->token = $token;

    }

    /**
     * get the auth token
     * @return string
     */
    public function getToken()
    {

        return $this->token;

    }

}
