<?php

class TheTwelve_Foursquare_AuthenticationGatewayTest
    extends PHPUnit_Framework_TestCase
{

    public function testProperties()
    {

        $gateway = $this->getAuthenticationGateway();

        $this->assertAttributeEquals($_GET['clientId'], 'clientId', $gateway);
        $this->assertAttributeEquals($_GET['clientSecret'], 'clientSecret', $gateway);
        $this->assertAttributeEquals($_GET['authorizeUri'], 'authorizeUri', $gateway);
        $this->assertAttributeEquals($_GET['accessTokenUri'], 'accessTokenUri', $gateway);
        $this->assertAttributeEquals($_GET['redirectUri'], 'redirectUri', $gateway);

    }

    public function testLogin()
    {

        $gateway = $this->getAuthenticationGateway();



    }

    public function testAuthentication()
    {

        $gateway = $this->getAuthenticationGateway();

    }

    protected function getAuthenticationGateway()
    {

        $client = $this->getMockForAbstractClass(
        	'TheTwelve\Foursquare\HttpClient'
        );

        $gateway = new \TheTwelve\Foursquare\AuthenticationGateway($client);
        $gateway->setClientCredentials($_GET['clientId'], $_GET['clientSecret']);
        $gateway->setAuthorizeUri($_GET['authorizeUri']);
        $gateway->setAccessTokenUri($_GET['accessTokenUri']);
        $gateway->setRedirectUri($_GET['redirectUri']);

        return $gateway;

    }

}
