<?php

class TheTwelve_Foursquare_HttpClient_BuzzHttpClientTest
    extends PHPUnit_Framework_TestCase
{

    public function testGet()
    {

        $browser = new \Buzz\Browser();
        $client = new \TheTwelve\Foursquare\HttpClient\BuzzHttpClient($browser);

        //$result = $client->get();

    }

    public function testPost()
    {

    }

}
