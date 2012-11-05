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

        $this->assertAttributeEquals($client, 'client', $factory);
        $this->assertAttributeEquals($version, 'version', $factory);
        $this->assertAttributeEquals($_GET['endpointUri'], 'endpointUri', $factory);
        $this->assertAttributeEquals($token, 'token', $factory);

        $gateway = $factory->getUserGateway();

        $this->assertAttributeEquals($requestUri, 'requestUri', $factory);

    }

    public function testAuthenticationGateway()
    {

        $client = $this->getMockForAbstractClass(
        	'TheTwelve\Foursquare\HttpClient'
        );

        $factory = $this->createFactory($client);

        $gateway = $factory->getAuthenticationGateway(
            $_GET['clientId'],
            $_GET['clientSecret'],
            $_GET['authorizeUri'],
            $_GET['accessTokenUri'],
            $_GET['redirectUri']
        );

        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\EndpointGateway);
        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\AuthenticationGateway);

        $this->assertAttributeEquals($_GET['clientId'], 'id', $gateway);
        $this->assertAttributeEquals($_GET['clientSecret'], 'secret', $gateway);
        $this->assertAttributeEquals($_GET['authorizeUri'], 'authorizeUri', $gateway);
        $this->assertAttributeEquals($_GET['accessTokenUri'], 'accessTokenUri', $gateway);
        $this->assertAttributeEquals($_GET['redirectUri'], 'redirectUri', $gateway);

        $this->assertAttributeEquals($client, 'client', $gateway);
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

        $gateway = $factory->getUserGateway();

        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\EndpointGateway);
        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\UsersGateway);

        $this->assertAttributeEquals($client, 'client', $gateway);
        $this->assertAttributeEquals($token, 'token', $gateway);
        $this->assertAttributeEquals($_GET['endpointUri'] . '/v2', 'requestUri', $gateway);

    }

	/**
     * @expectedException    RuntimeException
     */
    public function testUserGatewayWithNoToken()
    {

        $client = $this->getMockForAbstractClass(
        	'TheTwelve\Foursquare\HttpClient'
        );

        $factory = $this->createFactory($client);
        $gateway = $factory->getUserGateway();

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
