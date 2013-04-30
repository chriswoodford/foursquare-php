<?php

class TheTwelve_Foursquare_HttpClient_SymfonyRedirectorTest
    extends PHPUnit_Framework_TestCase
{

    public function testRedirect()
    {

        $client = new \TheTwelve\Foursquare\Redirector\SymfonyRedirector();
        $result = $client->redirect('http://example.com');

        $this->assertTrue($result instanceof \Symfony\Component\HttpFoundation\RedirectResponse);

    }

}
