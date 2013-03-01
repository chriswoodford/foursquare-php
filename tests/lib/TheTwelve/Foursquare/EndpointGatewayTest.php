<?php

class TheTwelve_Foursquare_EndpointGatewayTest
    extends PHPUnit_Framework_TestCase
{

    public function testMakeApiRequest()
    {

        $venueResponse = '{"meta": {"code": 200}, "notifications": [{"type": "notificationTray", "item": {"unreadCount": 0}}], "response": {"venues": [{"id": "4a809c7df964a520b2f51fe3", "name": "Starbucks"},{"id": "4e4dcb0bbd41b76bef9333a6","name": "Starbucks"}]}}';
        $venueJson = json_decode($venueResponse);

        $client = $this->getMockForAbstractClass(
        	'TheTwelve\Foursquare\HttpClient'
        );
        $client->expects($this->once())
             ->method('get')
             ->will($this->returnValue($venueResponse));

        $uri = $_GET['endpointUri'] . '/v2';
        $clientId = 'YYY0987654321ZZZ';
        $clientSecret = '1234567654321';

        $gateway = $this->createUnauthenticatedEndpointGateway($client, $uri, $clientId, $clientSecret);

        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\EndpointGateway);
        $this->assertAttributeEquals($client, 'httpClient', $gateway);
        $this->assertAttributeEquals($uri, 'requestUri', $gateway);
        $this->assertAttributeEquals($clientId, 'clientId', $gateway);
        $this->assertAttributeEquals($clientSecret, 'clientSecret', $gateway);

        $response = $gateway->makeApiRequest('/venues/search', array(
            'll' => '40.727198,-73.992289',
            'query' => 'Starbucks',
            'radius' => 1000,
            'intent' => 'checkin',
        ));

        $this->assertEquals($venueJson->response, $response);

    }

    public function testMakeAuthenticatedApiRequest()
    {

        $userId = '1234567890';
        $userResponse = '{"meta": {"code": 200}, "notifications": [{"type": "notificationTray","item":{"unreadCount": 0}}],"response": {"user": {"id": "' . $userId . '"}}}';
        $userJson = json_decode($userResponse);

        $client = $this->getMockForAbstractClass(
        	'TheTwelve\Foursquare\HttpClient'
        );
        $client->expects($this->once())
             ->method('get')
             ->will($this->returnValue($userResponse));


        $uri = $_GET['endpointUri'] . '/v2';
        $token = 'YYY0987654321ZZZ';

        $gateway = $this->createAuthenticatedEndpointGateway($client, $uri, $token);

        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\EndpointGateway);
        $this->assertAttributeEquals($client, 'httpClient', $gateway);
        $this->assertAttributeEquals($uri, 'requestUri', $gateway);
        $this->assertAttributeEquals($token, 'token', $gateway);

        $response = $gateway->makeAuthenticatedApiRequest('/users/' . $userId);

        $this->assertEquals($userJson->response, $response);
        $this->assertEquals($response->user->id, $userId);

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
