<?php

class TheTwelve_Foursquare_EndpointGatewayTest
    extends PHPUnit_Framework_TestCase
{

    public function testMakeApiRequest()
    {

        $client = $this->getMockForAbstractClass(
        	'TheTwelve\Foursquare\HttpClient'
        );

        $uri = $_GET['endpointUri'] . '/v2';
        $clientId = 'YYY0987654321ZZZ';
        $clientSecret = '1234567654321';

        $gateway = $this->createUnauthenticatedEndpointGateway($client, $uri, $clientId, $clientSecret);

        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\EndpointGateway);
        $this->assertAttributeEquals($client, 'client', $gateway);
        $this->assertAttributeEquals($uri, 'requestUri', $gateway);
        $this->assertAttributeEquals($clientId, 'clientId', $gateway);
        $this->assertAttributeEquals($clientSecret, 'clientSecret', $gateway);

    }

    public function testMakeAuthenticatedApiRequest()
    {

        $client = $this->getMockForAbstractClass(
        	'TheTwelve\Foursquare\HttpClient'
        );

        $uri = $_GET['endpointUri'] . '/v2';
        $token = 'YYY0987654321ZZZ';

        $gateway = $this->createAuthenticatedEndpointGateway($client, $uri, $token);

        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\EndpointGateway);
        $this->assertAttributeEquals($client, 'client', $gateway);
        $this->assertAttributeEquals($uri, 'requestUri', $gateway);
        $this->assertAttributeEquals($token, 'token', $gateway);

    }

    protected function createUnauthenticatedEndpointGateway($client, $uri, $id, $secret)
    {

        $gateway = new \TheTwelve\Foursquare\EndpointGateway($client);
        $gateway->setRequestUri($uri);
        $gateway->setClientCredentials($id, $secret);

        return $gateway;

    }

    protected function createAuthenticatedEndpointGateway($client, $uri, $token)
    {

        $gateway = new \TheTwelve\Foursquare\EndpointGateway($client);
        $gateway->setRequestUri($uri);
        $gateway->setToken($token);

        return $gateway;

    }

}
