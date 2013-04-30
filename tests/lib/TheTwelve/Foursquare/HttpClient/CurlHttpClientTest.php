<?php

class TheTwelve_Foursquare_HttpClient_CurlHttpClientTest
    extends PHPUnit_Framework_TestCase
{

    public function testSSL()
    {

        $client = new \TheTwelve\Foursquare\HttpClient\CurlHttpClient();

        $this->assertAttributeEquals(true, 'verifyPeer', $client);
        $this->assertAttributeEquals(2, 'verifyHost', $client);

        $client->setVerifyHost(1);
        $this->assertAttributeEquals(1, 'verifyHost', $client);

        $client->setVerifyHost(0);
        $this->assertAttributeEquals(0, 'verifyHost', $client);

        $client->setVerifyHost(2);
        $this->assertAttributeEquals(2, 'verifyHost', $client);

        $client->setVerifyPeer(false);
        $this->assertAttributeEquals(false, 'verifyPeer', $client);

        $client->setVerifyPeer(true);
        $this->assertAttributeEquals(true, 'verifyPeer', $client);

    }

    public function testGet()
    {

    }

    public function testPost()
    {

    }

}
