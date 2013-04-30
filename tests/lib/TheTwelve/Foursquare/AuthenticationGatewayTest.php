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

        $redirector = $this->getRedirector();

        $gateway = $this->getAuthenticationGateway(null, $redirector);

        $uri = $gateway->getAuthenticationUri();

        $redirector->expects($this->once())
                   ->method('redirect')
                   ->with($uri)
                   ->will($this->returnValue($uri));

        $ret = $gateway->initiateLogin();

        $this->assertEquals($uri, $ret);

    }

    public function testCannotBuildAuthenticationUri()
    {

        $client = $this->getHttpClient();
        $redirector = $this->getRedirector();

        $gateway = new \TheTwelve\Foursquare\AuthenticationGateway($client, $redirector);

        $this->setExpectedException('RuntimeException');
        $uri = $gateway->getAuthenticationUri();

    }

    public function testAuthentication()
    {

        $code = 'QWERTYUIOP';
        $token = "ASDFGHJKL";
        $tokenJson = '{"access_token":"' . $token . '"}';

        $client = $this->getHttpClient();
        $client->expects($this->once())
               ->method('get')
               ->with($_GET['accessTokenUri'], array(
                    'client_id' => $_GET['clientId'],
                    'client_secret' => $_GET['clientSecret'],
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => $_GET['redirectUri'],
                    'code' => $code,
                ))
               ->will($this->returnValue($tokenJson));

        $gateway = $this->getAuthenticationGateway($client);
        $ret = $gateway->authenticateUser($code);

        $this->assertEquals($token, $ret);

    }

    protected function getAuthenticationGateway($client = null, $redirector = null)
    {

        if (is_null($client)) {
            $client = $this->getHttpClient();
        }

        if (is_null($redirector)) {
            $redirector = $this->getRedirector();
        }

        $gateway = new \TheTwelve\Foursquare\AuthenticationGateway($client, $redirector);
        $gateway->setClientCredentials($_GET['clientId'], $_GET['clientSecret']);
        $gateway->setAuthorizeUri($_GET['authorizeUri']);
        $gateway->setAccessTokenUri($_GET['accessTokenUri']);
        $gateway->setRedirectUri($_GET['redirectUri']);

        return $gateway;

    }

    protected function getHttpClient()
    {
        return $this->getMockForAbstractClass('TheTwelve\Foursquare\HttpClient');
    }

    protected function getRedirector()
    {
        return $this->getMockForAbstractClass('TheTwelve\Foursquare\Redirector');
    }

}
