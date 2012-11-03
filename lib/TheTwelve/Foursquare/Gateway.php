<?php

namespace TheTwelve\Foursquare;

abstract class Gateway
{

    /** @var TheTwelve\Foursquare\HttpClient */
    protected $client;

    /** @var string */
    protected $token;

    /** @var string */
    protected $endpointUri;

    /** @var string */
    protected $version;

    /**
     * initialize the gateway
     * @param TheTwelve\Foursquare\HttpClient;
     */
    public function __construct(HttpClient $client)
    {

        $this->client = $client;
        $this->version = 'v2';

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

    /**
     * set the api endpoint uri
     * @param string $uri
     */
    public function setEndpointUri($uri)
    {

        $this->endpointUri = $uri;

    }

    /**
     * set the version
     * @param string $version
     */
    public function setVersion($version)
    {

        $this->version = $version;

    }

    /**
     * make a request to the api
     * @param string $uri
     * @param array $params
     * @param string $method
     * @return stdClass
     */
    protected function makeApiRequest($uri, array $params = array(), $method = 'GET')
    {

        $uri = $this->endpointUri . '/' . $this->version . $uri;
        $params['oauth_token'] = $this->token;
        $params['v'] = date('Ymd');

        $response = json_decode($this->client->get($uri, $params));

        // TODO: handle meta data from response
        // "meta":{"code":200},"notifications":[{"type":"notificationTray","item":{"unreadCount":0}}]

        return $response->response;

    }

}
