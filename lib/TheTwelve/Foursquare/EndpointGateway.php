<?php

namespace TheTwelve\Foursquare;

class EndpointGateway
{

    /** @var \TheTwelve\Foursquare\HttpClient */
    protected $httpClient;

    /** @var string */
    protected $token;

    /** @var string */
    protected $requestUri;

    /** @var string */
    protected $clientId;

    /** @var string */
    protected $clientSecret;

    /**
     * initialize the gateway
     * @param \TheTwelve\Foursquare\HttpClient $client
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * set the request uri
     * @param string $requestUri
     * @return \TheTwelve\Foursquare\EndpointGateway
     */
    public function setRequestUri($requestUri)
    {
        $this->requestUri = rtrim($requestUri, '/');
        return $this;
    }

    /**
     * set the api endpoint uri
     * @param string $id
     * @param string $secret
     * @return \TheTwelve\Foursquare\EndpointGateway
     */
    public function setClientCredentials($id, $secret)
    {
        $this->clientId = $id;
        $this->clientSecret = $secret;
        return $this;
    }

    /**
     * set the auth token
     * @param string $token
     * @return \TheTwelve\Foursquare\EndpointGateway
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * make an authenticated request to the api
     * @param string $resource
     * @param array $params
     * @param string $method
     * @return stdClass
     */
    public function makeAuthenticatedApiRequest($resource, array $params = array(), $method = 'GET')
    {

        $this->assertHasActiveUser();
        $params['oauth_token'] = $this->token;
        return $this->makeApiRequest($resource, $params, $method);

    }

    /**
     * make a generic request to the api
     * @param string $resource
     * @param array $params
     * @param string $method
     * @return \stdClass
     */
    public function makeApiRequest($resource, array $params = array(), $method = 'GET')
    {

        $uri = $this->requestUri . '/' . ltrim($resource, '/');

        if ($this->hasValidToken()) {
            $params['oauth_token'] = $this->token;
        } else {
            $params['client_id'] = $this->clientId;
            $params['client_secret'] = $this->clientSecret;
        }

        // apply a dated "version"
        $params['v'] = date('Ymd');

        switch ($method) {
            case 'GET':
                $response = json_decode($this->httpClient->get($uri, $params));
                break;
            case 'POST':
                $response = json_decode($this->httpClient->post($uri, $params));
                break;
            default:
                throw new \RuntimeException('Currently only HTTP methods "GET" and "POST" are supported.');
        }

        //TODO check headers for api request limit

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

                //TODO handle notifications

            }

        }

        return $response->response;

    }

    /**
     * assert that there is an active user
     * @throws \RuntimeException
     */
    protected function assertHasActiveUser()
    {
        if (!$this->hasValidToken()) {
            throw new \RuntimeException('No valid oauth token found.');
        }
    }

    /**
     * checks if a valid token exists
     * @return boolean
     */
    protected function hasValidToken()
    {
        return (bool) $this->token;
    }

}
