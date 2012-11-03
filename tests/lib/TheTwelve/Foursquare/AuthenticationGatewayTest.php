<?php

class TheTwelve_Foursquare_AuthenticationGatewayTest
    extends PHPUnit_Framework_TestCase
{

    public function testLogin()
    {

        $gateway = $this->getAuthenticationGateway();
        $gateway->initiateLogin();


    }

    protected function getAuthenticationGateway()
    {

        $client = new \TheTwelve\Foursquare\HttpClient\SymfonyHttpClient();

        $gateway = new \TheTwelve\Foursquare\AuthenticationGateway($client);
        $gateway->setAuthorizationParams($_GET['clientId'], $_GET['clientSecret']);
        $gateway->setAuthorizeUri($_GET['authorizeUri']);
        $gateway->setAccessTokenUri($_GET['accessTokenUri']);
        $gateway->setRedirectUri($_GET['redirectUri']);

        return $gateway;

    }

}
