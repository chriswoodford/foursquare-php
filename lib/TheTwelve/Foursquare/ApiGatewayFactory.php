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
     * factory method for users gateway
     * @param string|null $userId
     * @return TheTwelve\Foursquare\UsersGateway
     */
    public function getUsersGateway($userId = null)
    {

        $gateway = new UsersGateway($this->client);
        $gateway->setUserId($userId);

        $this->injectGatewayDependencies($gateway);
        return $gateway;

    }

    /**
     * factory method for venues gateway
     * @return TheTwelve\Foursquare\VenuesGateway
     */
    public function getVenuesGateway()
    {

        $gateway = new VenuesGateway($this->client);
        $this->injectGatewayDependencies($gateway);
        return $gateway;

    }

    /**
     * factory method for venue groups gateway
     * @return TheTwelve\Foursquare\VenueGroupsGateway
     */
    public function getVenueGroupsGateway()
    {

        $gateway = new VenueGroupsGateway($this->client);
        $this->injectGatewayDependencies($gateway);
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
     * inject the minimum required dependencies
     */
    protected function injectGatewayDependencies(EndpointGateway $gateway)
    {

        if (!$this->hasValidToken()) {
            throw new \RuntimeException('No valid oauth token was found');
        }

        $gateway->setRequestUri($this->getRequestUri())
                ->setToken($this->token);

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
