<?php

namespace TheTwelve\Foursquare;

class AuthenticationGateway extends Gateway
{

    /** @var string */
    protected $id;

    /** @var string */
    protected $secret;

    /** @var string */
    protected $authorizeUri;

    /** @var string */
    protected $accessTokenUri;

    /** @var string */
    protected $redirectUri;

    /**
     * set authentication params
     * @param string $id
     * @param string $secret
     */
    public function setAuthorizationParams($id, $secret)
    {

        $this->id = $id;
        $this->secret = $secret;

    }

    /**
     * set the authentication uri
     * @param string $uri
     */
    public function setAuthorizeUri($uri)
    {

        $this->authorizeUri = $uri;

    }

    /**
     * set the access token uri
     * @param string $uri
     */
    public function setAccessTokenUri($uri)
    {

        $this->accessTokenUri = $uri;

    }

    /**
     * set the redirect uri
     * @param string $uri
     */
    public function setRedirectUri($uri)
    {

        $this->redirectUri = $uri;

    }

    /**
     * initiate the login process
     * @see https://developer.foursquare.com/overview/auth.html
     * @return mixed
     */
    public function initiateLogin()
    {

        if (!$this->canInitiateLogin()) {
            throw new \RuntimeException(
            	'Cannot authenticate user, dependencies are missing'
            );
        }

        $uriParams = array(
            'client_id' => $this->id,
            'response_type' => 'code',
            'redirect_uri' => $this->redirectUri,
        );

        $uri = $this->authorizeUri . '?' . http_build_query($uriParams);
        return $this->client->redirect($uri);

    }

    /**
     * authenticate the user with the response code
     * @see https://developer.foursquare.com/overview/auth.html
     * @param string $code
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

        $uriParams = array(
            'client_id' => $this->id,
            'client_secret' => $this->secret,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->redirectUri,
            'code' => $code,
        );

        $response = json_decode($this->client->get($this->accessTokenUri, $uriParams));
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

        return $this->id && $this->redirectUri && $this->authorizeUri;

    }

    /**
     * assert that it is possible to proceed with authenticating the user
     * @return boolean
     */
    protected function canAuthenticateUser()
    {

        return $this->id && $this->secret
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
