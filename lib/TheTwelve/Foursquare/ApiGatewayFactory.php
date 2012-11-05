<?php

namespace TheTwelve\Foursquare;

class ApiGatewayFactory
{

    /** @var TheTwelve\Foursquare\HttpClient */
    protected $client;

    /** @var string */
    protected $version;

    /** @var string */
    protected $endpointUri;

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
     * tell the factory to use the supplied version
     * @param integer $version
     * @return TheTwelve\Foursquare\ApiGatewayFactory
     */
    public function useVersion($version)
    {

        $this->version = 'v' . $version;
        return $this;

    }

    /**
     * set the api endpoint uri
     * @param string $uri
     * @return TheTwelve\Foursquare\ApiGatewayFactory
     */
    public function setEndpointUri($uri)
    {

        $this->endpointUri = $uri;
        return $this;

    }

    /**
     * set the oauth token
     * @param string $uri
     * @return TheTwelve\Foursquare\ApiGatewayFactory
     */
    public function setToken($token)
    {

        $this->token = $token;
        return $this;

    }

    /**
     * factory method for authentication gateway
     * @param string $id
     * @param string $secret
     * @param string $authorizeUri
     * @param string $accessTokenUri
     * @param string $redirectUri
     * @return TheTwelve\Foursquare\AuthenticationGateway
     */
    public function getAuthenticationGateway(
        $id, $secret, $authorizeUri, $accessTokenUri, $redirectUri
    ) {

        $gateway = new AuthenticationGateway($this->client, $this);
        $gateway->setAuthorizationParams($id, $secret)
                ->setAuthorizeUri($authorizeUri)
                ->setAccessTokenUri($accessTokenUri)
                ->setRedirectUri($redirectUri);

        return $gateway;

    }

    /**
     * factory method for user gateway
     * @return TheTwelve\Foursquare\UserGateway
     */
    public function getUserGateway()
    {

        if (!$this->hasValidToken()) {
            throw new \RuntimeException('No valid oauth token was found');
        }

        $gateway = new UsersGateway($this->client);
        $gateway->setRequestUri($this->getRequestUri())
                ->setToken($this->token);

        return $gateway;

    }

    /**
     * get the uri to make requests to
     * @return string
     */
    protected function getRequestUri()
    {

        if (!$this->requestUri) {
            $this->requestUri = rtrim($this->endpointUri, '/') . '/' . $this->version;
        }

        return $this->requestUri;

    }

    /**
     * checks if a valid token exists
     * @return boolean
     */
    protected function hasValidToken()
    {

        return $this->token ? true : false;
    }

}
