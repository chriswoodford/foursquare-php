<?php

namespace TheTwelve\Foursquare;

class AuthenticationGateway extends EndpointGateway
{

    /** @var string */
    protected $authorizeUri;

    /** @var string */
    protected $accessTokenUri;

    /** @var string */
    protected $redirectUri;

    /** @var \TheTwelve\Foursquare\Redirector */
    protected $redirector;

    /**
     * initialize the authentication gateway
     * @param \TheTwelve\Foursquare\HttpClient $httpClient
     * @param \TheTwelve\Foursquare\Redirector $redirector
     */
    public function __construct(HttpClient $httpClient, Redirector $redirector)
    {

        parent::__construct($httpClient);
        $this->redirector = $redirector;

    }

    /**
     * set the authentication uri
     * @param string $uri
     * @return \TheTwelve\Foursquare\AuthenticationGateway
     */
    public function setAuthorizeUri($uri)
    {

        $this->authorizeUri = $uri;
        return $this;

    }

    /**
     * set the access token uri
     * @param string $uri
     * @return \TheTwelve\Foursquare\AuthenticationGateway
     */
    public function setAccessTokenUri($uri)
    {

        $this->accessTokenUri = $uri;
        return $this;

    }

    /**
     * set the redirect uri
     * @param string $uri
     * @return \TheTwelve\Foursquare\AuthenticationGateway
     */
    public function setRedirectUri($uri)
    {

        $this->redirectUri = $uri;
        return $this;

    }

    /**
     * initiate the login process
     * @see https://developer.foursquare.com/overview/auth.html
     * @throws \RuntimeException
     * @return mixed
     */
    public function initiateLogin()
    {

        if (!$this->canInitiateLogin()) {
            throw new \RuntimeException(
            	'Unable to initiate login'
            );
        }

        $uri = $this->getAuthenticationUri();
        return $this->redirector->redirect($uri);

    }

    /**
     * build the foursquare authentication uri that users are
     * forwarded to for authentication
     * @see https://developer.foursquare.com/overview/auth.html
     * @return string
     */
    public function getAuthenticationUri()
    {

        if (!$this->canBuildAuthenticationUri()) {
            throw new \RuntimeException(
            	'Cannot build authentication uri, dependencies are missing'
            );
        }

        $uriParams = array(
            'client_id' => $this->clientId,
            'response_type' => 'code',
            'redirect_uri' => $this->redirectUri,
        );

        return $this->authorizeUri . '?' . http_build_query($uriParams);

    }

    /**
     * authenticate the user with the response code
     * @see https://developer.foursquare.com/overview/auth.html
     * @param string $code
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     * @return string
     */
    public function authenticateUser($code)
    {

        if (!$this->canAuthenticateUser()) {
            throw new \RuntimeException(
            	'Cannot authenticate user, dependencies are missing'
            );
        }

        if (!$this->codeIsValid($code)) {
            throw new \InvalidArgumentException('Foursquare code is invalid');
        }

        $response = json_decode($this->httpClient->get($this->accessTokenUri, array(
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->redirectUri,
            'code' => $code,
        )));

        $this->token = isset($response->access_token)
            ? $response->access_token : null;

        return $this->token;

    }

    /**
     * assert that it is possible to proceed with initiating the login
     * @return boolean
     */
    protected function canInitiateLogin()
    {
        return true;
    }

    /**
     * assert that it is possible to build the authentication uri
     * @return boolean
     */
    protected function canBuildAuthenticationUri()
    {
        return $this->clientId && $this->redirectUri && $this->authorizeUri;
    }

    /**
     * assert that it is possible to proceed with authenticating the user
     * @return boolean
     */
    protected function canAuthenticateUser()
    {
        return $this->clientId && $this->clientSecret
            && $this->redirectUri && $this->accessTokenUri;
    }

    /**
     * assert that the foursquare code is valid for use
     * @param string $code
     * @return boolean
     */
    protected function codeIsValid($code)
    {
        return !is_null($code);
    }

}
