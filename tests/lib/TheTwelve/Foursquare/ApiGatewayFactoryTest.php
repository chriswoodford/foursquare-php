<?php

class TheTwelve_Foursquare_ApiGatewayFactoryTest
    extends PHPUnit_Framework_TestCase
{

    public function testProperties()
    {

        $client = $this->getHttpClient();
        $token = 'XXXX1234567890FFF';
        $version = 'v2';
        $requestUri = $_GET['endpointUri'] . '/' . $version;

        $factory = $this->createFactory($client, $token);

        // force call to injectGatewayDependencies to build requestUri
        $factory->getGenericGateway();

        $this->assertAttributeEquals($client, 'httpClient', $factory);
        $this->assertAttributeEquals($version, 'version', $factory);
        $this->assertAttributeEquals($_GET['endpointUri'], 'endpointUri', $factory);
        $this->assertAttributeEquals($token, 'token', $factory);
        $this->assertAttributeEquals($requestUri, 'requestUri', $factory);

    }

    public function testAuthenticationGateway()
    {

        $client = $this->getHttpClient();
        $redirector = $this->getMockForAbstractClass('TheTwelve\Foursquare\Redirector');

        $factory = $this->createFactory($client, null, $redirector);
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

    public function testAuthenticationGatewatWithoutRedirector()
    {

        $client = $this->getHttpClient();

        $factory = $this->createFactory($client);
        $factory->setClientCredentials($_GET['clientId'], $_GET['clientSecret']);

        $this->setExpectedException('RuntimeException');
        $gateway = $factory->getAuthenticationGateway(
            $_GET['authorizeUri'],
            $_GET['accessTokenUri'],
            $_GET['redirectUri']
        );

    }

    public function testUserGateway()
    {

        $client = $this->getHttpClient();
        $token = 'XXXX1234567890FFF';

        $factory = $this->createFactory($client, $token);
        $gateway = $factory->getUsersGateway();

        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\EndpointGateway);
        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\UsersGateway);

        $this->assertAttributeEquals($client, 'httpClient', $gateway);
        $this->assertAttributeEquals($token, 'token', $gateway);
        $this->assertAttributeEquals($_GET['endpointUri'] . '/v2', 'requestUri', $gateway);

    }

    public function testPhotosGateway()
    {

        $client = $this->getHttpClient();
        $token = 'XXXX1234567890FFF';

        $factory = $this->createFactory($client, $token);
        $gateway = $factory->getPhotosGateway();

        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\EndpointGateway);
        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\PhotosGateway);

    }

    public function testCheckinsGateway()
    {

        $client = $this->getHttpClient();
        $token = 'XXXX1234567890FFF';

        $factory = $this->createFactory($client, $token);
        $gateway = $factory->getCheckinsGateway();

        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\EndpointGateway);
        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\CheckinsGateway);

    }

    public function testVenuesGateway()
    {

        $client = $this->getHttpClient();
        $factory = $this->createFactory($client);
        $factory->setClientCredentials($_GET['clientId'], $_GET['clientSecret']);

        $gateway = $factory->getVenuesGateway();

        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\EndpointGateway);
        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\VenuesGateway);

    }

    public function testVenueGroupsGateway()
    {

        $client = $this->getHttpClient();
        $factory = $this->createFactory($client);
        $factory->setClientCredentials($_GET['clientId'], $_GET['clientSecret']);

        $gateway = $factory->getVenueGroupsGateway();

        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\EndpointGateway);
        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\VenueGroupsGateway);

    }

    public function testGenericGateway()
    {

    }

    protected function createFactory($client, $token = null, $redirector = null)
    {

        $factory = new \TheTwelve\Foursquare\ApiGatewayFactory($client, $redirector);
        $factory->useVersion(2);
        $factory->setEndpointUri($_GET['endpointUri']);
        $factory->setToken($token);

        return $factory;

    }

    protected function getHttpClient()
    {

        return $this->getMockForAbstractClass(
        	'TheTwelve\Foursquare\HttpClient'
        );

    }

}
