<?php

namespace TheTwelve\Foursquare;

abstract class EndpointGateway
{

    /** @var TheTwelve\Foursquare\HttpClient */
    protected $client;

    /** @var string */
    protected $token;

    /** @var string */
    protected $requestUri;

    /**
     * initialize the gateway
     * @param TheTwelve\Foursquare\HttpClient;
     */
    public function __construct(HttpClient $client)
    {

        $this->client = $client;

    }

    /**
     * set the request uri
     * @param string $uri
     * @return TheTwelve\Foursquare\EndpointGateway
     */
    public function setRequestUri($requestUri)
    {

        $this->requestUri = rtrim($requestUri, '/');
        return $this;

    }

    /**
     * set the auth token
     * @param string $token
     * @return TheTwelve\Foursquare\EndpointGateway
     */
    public function setToken($token)
    {

        $this->token = $token;
        return $this;

    }

    /**
     * make a request to the api
     * @param string $resource
     * @param array $params
     * @param string $method
     * @return stdClass
     */
    protected function makeApiRequest($resource, array $params = array(), $method = 'GET')
    {

        $uri = $this->requestUri . '/' . $resource;

        $params['oauth_token'] = $this->token;
        $params['v'] = date('Ymd');

        switch ($method) {

            case 'GET':
                $response = json_decode($this->client->get($this->requestUri, $params));
                break;

            default:
                //TODO throw not implemented exception

        }

        if (isset($response->meta)) {

            if (isset($response->meta->code)
                && $response->meta->code != 200
            ) {
                //TODO handle case
            }

            if (isset($response->meta->notifications)
                && is_array($response->meta->notifications)
                && count($response->meta->notifications)
            ) {

                //TODO handle notifications. loggging

            }

        }

        return $response->response;

    }

}
