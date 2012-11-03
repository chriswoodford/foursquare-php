<?php

namespace Foursquare;

class AuthenticationGateway
{

    /** @var string */
    protected $id;

    /** @var string */
    protected $secret;

    /** @var string */
    protected $authenticationUri;

    /** @var string */
    protected $accessTokenUri;

    /** @var string */
    protected $redirectUri;

    /** @var Foursquare\HttpClient */
    protected $client;

    /**
     * initialize the gateway
     * @param Foursquare\HttpClient;
     */
    public function __construct(HttpClient $client)
    {

        $this->client = $client;

    }

    /**
     * set authentication params
     * @param string $id
     * @param string $secret
     */
    public function setAuthenticationParams($id, $secret)
    {

        $this->id = $id;
        $this->secret = $secret;

    }

    /**
     * set the authentication uri
     * @param string $uri
     */
    public function setAuthenticationUri($uri)
    {

        $this->authenticationUri = $uri;

    }

    /**
     * set the access token uri
     * @param unknown_type $uri
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

    public function initiateLogin()
    {

        //TODO: add validation

        $uriParams = array(
            'client_id' => $this->id,
            'response_type' => 'code',
            'redirect_uri' => $this->redirectUri,
        );

        header('Location: ' . $this->authenticationUri . '?' . http_build_query($uriParams));

    }

    public function authenticateUser($code)
    {

        //TODO: add validation

        $uriParams = array(
            'client_id' => $this->id,
            'client_secret' => $this->secret,
            'grant_type' => 'authorization_code',
            'redirect_url' => $this->redirectUri,
            'code' => $code,
        );



    }

}
