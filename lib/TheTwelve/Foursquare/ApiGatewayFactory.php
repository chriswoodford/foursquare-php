<?php

namespace TheTwelve\Foursquare;

class ApiGatewayFactory
{

    /** @var \TheTwelve\Foursquare\HttpClient */
    protected $httpClient;

    /** @var string */
    protected $version = 'v2';

    /** @var string */
    protected $endpointUri = 'https://api.foursquare.com';

    /** @var string */
    protected $token;

    /** @var string */
    protected $requestUri;

    /**
     * initialize the gateway
     * @param \TheTwelve\Foursquare\HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {

        $this->httpClient = $httpClient;

    }

    /**
     * tell the factory to use the supplied version
     * @param integer $version
     * @return \TheTwelve\Foursquare\ApiGatewayFactory
     */
    public function useVersion($version)
    {

        $this->version = 'v' . $version;
        return $this;

    }

    /**
     * set the api endpoint uri
     * @param string $id
     * @param string $secret
     * @return \TheTwelve\Foursquare\ApiGatewayFactory
     */
    public function setClientCredentials($id, $secret)
    {

        $this->clientId = $id;
        $this->clientSecret = $secret;
        return $this;

    }

    /**
     * set the api endpoint uri
     * @param string $uri
     * @return \TheTwelve\Foursquare\ApiGatewayFactory
     */
    public function setEndpointUri($uri)
    {

        $this->endpointUri = $uri;
        return $this;

    }

    /**
     * set the oauth token
     * @param string $token
     * @return  \TheTwelve\Foursquare\ApiGatewayFactory
     */
    public function setToken($token)
    {

        $this->token = $token;
        return $this;

    }

    /**
     * factory method for authentication gateway
     * @param string $authorizeUri
     * @param string $accessTokenUri
     * @param string $redirectUri
     * @return \TheTwelve\Foursquare\AuthenticationGateway
     */
    public function getAuthenticationGateway(
        $authorizeUri, $accessTokenUri, $redirectUri
    ) {

        $gateway = new AuthenticationGateway($this->httpClient);
        $gateway->setAuthorizeUri($authorizeUri)
                ->setAccessTokenUri($accessTokenUri)
                ->setRedirectUri($redirectUri);

        return $gateway;

    }

    /**
     * factory method for users gateway
     * @param string|null $userId
     * @return \TheTwelve\Foursquare\UsersGateway
     */
    public function getUsersGateway($userId = null)
    {

        $gateway = new UsersGateway($this->httpClient);

        if (!is_null($userId)) {
            $gateway->setUserId($userId);
        }

        $this->injectGatewayDependencies($gateway);
        return $gateway;

    }

    /**
     * factory method for venues gateway
     * @param string $id
     * @param string $secret
     * @return \TheTwelve\Foursquare\VenuesGateway
     */
    public function getVenuesGateway()
    {
        $gateway = new VenuesGateway($this->httpClient);
        $this->injectGatewayDependencies($gateway);
        return $gateway;

    }

    /**
     * factory method for venue groups gateway
     * @return \TheTwelve\Foursquare\VenueGroupsGateway
     */
    public function getVenueGroupsGateway()
    {

        $gateway = new VenueGroupsGateway($this->httpClient);
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

        $gateway->setRequestUri($this->getRequestUri())
                ->setToken($this->token)
                ->setClientCredentials($this->clientId, $this->clientSecret);

    }

}
