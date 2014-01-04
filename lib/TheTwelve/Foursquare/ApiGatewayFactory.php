<?php

namespace TheTwelve\Foursquare;

class ApiGatewayFactory
{

    /** @var \TheTwelve\Foursquare\HttpClient */
    protected $httpClient;

    /** @var \TheTwelve\Foursquare\Redirector */
    protected $redirector;

    /** @var string */
    protected $version = 'v2';

    /** @var string */
    protected $endpointUri = 'https://api.foursquare.com';

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
     * @param \TheTwelve\Foursquare\HttpClient $httpClient
     * @param Redirector $redirector
     */
    public function __construct(HttpClient $httpClient, Redirector $redirector = null)
    {

        $this->httpClient = $httpClient;
        $this->redirector = $redirector;

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
     * set the client credentials
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
     * @throws \RuntimeException
     * @return \TheTwelve\Foursquare\AuthenticationGateway
     */
    public function getAuthenticationGateway(
        $authorizeUri, $accessTokenUri, $redirectUri
    ) {

        if (!$this->redirector instanceof Redirector) {
            throw new \RuntimeException("A Redirector is required for authentication");
        }

        $gateway = new AuthenticationGateway($this->httpClient, $this->redirector);
        $gateway->setAuthorizeUri($authorizeUri)
                ->setAccessTokenUri($accessTokenUri)
                ->setRedirectUri($redirectUri)
                ->setClientCredentials($this->clientId, $this->clientSecret);

        return $gateway;

    }

    /**
     * factory method for checkins gateway
     * @param string|null $userId
     * @return \TheTwelve\Foursquare\UsersGateway
     */
    public function getCheckinsGateway($userId = null)
    {

        $gateway = new CheckinsGateway($this->httpClient);
        $this->injectGatewayDependencies($gateway, $userId);
        return $gateway;

    }

    /**
     * factory method for photos gateway
     * @param string|null $userId
     * @return \TheTwelve\Foursquare\UsersGateway
     */
    public function getPhotosGateway($userId = null)
    {

        $gateway = new PhotosGateway($this->httpClient);
        $this->injectGatewayDependencies($gateway, $userId);
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
        $this->injectGatewayDependencies($gateway, $userId);
        return $gateway;

    }

    /**
     * factory method for users gateway
     * @param string|null $listId
     * @return \TheTwelve\Foursquare\ListsGateway
     */
    public function getListGateway($listId = null)
    {
        $gateway = new ListsGateway($this->httpClient);
        $this->injectListGatewayDependencies($gateway, $listId);
        return $gateway;
    }

    /**
     * factory method for venues gateway
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
     * factory method that returns a generic gateway, allowing requests
     * to be made directly to the foursquare api
     * @return \TheTwelve\Foursquare\EndpointGateway
     */
    public function getGenericGateway()
    {

        $gateway = new EndpointGateway($this->httpClient);
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
     * @param \TheTwelve\Foursquare\EndpointGateway $gateway
     * @param null $userId
     */
    protected function injectGatewayDependencies(EndpointGateway $gateway, $userId = null)
    {

        if (!is_null($userId)) {
            $gateway->setUserId($userId);
        }

        $gateway->setRequestUri($this->getRequestUri())
                ->setToken($this->token)
                ->setClientCredentials($this->clientId, $this->clientSecret);

    }

    /**
     * inject the minimum required dependencies
     * @param \TheTwelve\Foursquare\EndpointGateway $gateway
     * @param null $listId
     */
    protected function injectListGatewayDependencies(EndpointGateway $gateway, $listId = null)
    {
        if ($listId) {
            $gateway->setListId($listId);
        }
        $gateway->setRequestUri($this->getRequestUri())
                ->setToken($this->token)
                ->setClientCredentials($this->clientId, $this->clientSecret);
    }

}
