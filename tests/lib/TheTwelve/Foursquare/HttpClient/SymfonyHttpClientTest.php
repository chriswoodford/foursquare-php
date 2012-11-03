<?php

class TheTwelve_Foursquare_HttpClient_SymfonyHttpClientTest
    extends PHPUnit_Framework_TestCase
{

    public function testGet()
    {

//?client_id=G125LJ1S3MKPFVGSDI2G1ZLCGV15WTHBNOLWIAJRD1AKJG0P&client_secret=JSKC3VXH2LY2F2DLNVP0Y5A4JVSJLQQGONCWRVGF51ESET1A&code=GCEUHNWWA4IZLGYHO0RVMODVL2JDEJD2TWZR2HEBOB3ZKD5N&grant_type=authorization_code&redirect_url=http://tnphp.localhost:10088/foursquare

        $client = new \TheTwelve\Foursquare\HttpClient\SymfonyHttpClient();
        $result = $client->get('https://foursquare.com/oauth2/access_token');
echo $result; die;

    }

    public function testRedirect()
    {

        $client = new \TheTwelve\Foursquare\HttpClient\SymfonyHttpClient();
        $result = $client->redirect('http://google.ca');

        $this->assertTrue($result instanceof \Symfony\Component\HttpFoundation\RedirectResponse);

    }

}
