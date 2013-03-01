<?php

class TheTwelve_Foursquare_ApiGatewayFactoryTest
    extends PHPUnit_Framework_TestCase
{

    public function testProperties()
    {

        $client = $this->getMockForAbstractClass(
        	'TheTwelve\Foursquare\HttpClient'
        );

        $token = 'XXXX1234567890FFF';
        $version = 'v2';
        $requestUri = $_GET['endpointUri'] . '/' . $version;

        $factory = $this->createFactory($client, $token);

        $this->assertAttributeEquals($client, 'httpClient', $factory);
        $this->assertAttributeEquals($version, 'version', $factory);
        $this->assertAttributeEquals($_GET['endpointUri'], 'endpointUri', $factory);
        $this->assertAttributeEquals($token, 'token', $factory);

        $gateway = $factory->getUsersGateway();

        $this->assertAttributeEquals($requestUri, 'requestUri', $factory);

    }

    public function testAuthenticationGateway()
    {

        $client = $this->getMockForAbstractClass(
        	'TheTwelve\Foursquare\HttpClient'
        );

        $factory = $this->createFactory($client);

        $factory->setClientCredentials($_GET['clientId'], $_GET['clientSecret']);

        $gateway = $factory->getAuthenticationGateway(

            $_GET['authorizeUri'],
            $_GET['accessTokenUri'],
            $_GET['redirectUri']
        );

        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\EndpointGateway);
        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\AuthenticationGateway);

        $this->assertAttributeEquals($_GET['clientId'], 'clientId', $gateway);
        $this->assertAttributeEquals($_GET['clientSecret'], 'clientSecret', $gateway);
        $this->assertAttributeEquals($_GET['authorizeUri'], 'authorizeUri', $gateway);
        $this->assertAttributeEquals($_GET['accessTokenUri'], 'accessTokenUri', $gateway);
        $this->assertAttributeEquals($_GET['redirectUri'], 'redirectUri', $gateway);

        $this->assertAttributeEquals($client, 'httpClient', $gateway);
        $this->assertAttributeEquals(null, 'token', $gateway);
        $this->assertAttributeEquals(null, 'requestUri', $gateway);

    }

    public function testUserGateway()
    {

        $client = $this->getMockForAbstractClass(
        	'TheTwelve\Foursquare\HttpClient'
        );

        $token = 'XXXX1234567890FFF';

        $factory = $this->createFactory($client);
        $factory->setToken($token);

        $gateway = $factory->getUsersGateway();

        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\EndpointGateway);
        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\UsersGateway);

        $this->assertAttributeEquals($client, 'httpClient', $gateway);
        $this->assertAttributeEquals($token, 'token', $gateway);
        $this->assertAttributeEquals($_GET['endpointUri'] . '/v2', 'requestUri', $gateway);

    }

    protected function createFactory($client, $token = null)
    {

        $factory = new \TheTwelve\Foursquare\ApiGatewayFactory($client);
        $factory->useVersion(2);
        $factory->setEndpointUri($_GET['endpointUri']);
        $factory->setToken($token);

        return $factory;

    }

}
