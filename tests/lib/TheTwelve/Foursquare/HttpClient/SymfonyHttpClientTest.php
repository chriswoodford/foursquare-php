<?php

class TheTwelve_Foursquare_HttpClient_SymfonyHttpClientTest
    extends PHPUnit_Framework_TestCase
{

    public function testGet()
    {

        $client = new \TheTwelve\Foursquare\HttpClient\SymfonyHttpClient();
        //$result = $client->get('https://foursquare.com/oauth2/access_token');

    }

    public function testRedirect()
    {

        $client = new \TheTwelve\Foursquare\HttpClient\SymfonyHttpClient();
        $result = $client->redirect('http://example.com');

        $this->assertTrue($result instanceof \Symfony\Component\HttpFoundation\RedirectResponse);

    }

}
