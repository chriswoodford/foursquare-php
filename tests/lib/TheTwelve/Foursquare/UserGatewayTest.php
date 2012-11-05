<?php

class TheTwelve_Foursquare_UserGatewayTest
    extends PHPUnit_Framework_TestCase
{

    public function testProperties()
    {

        $client = new \TheTwelve\Foursquare\HttpClient\StubHttpClient();
        $uri = $_GET['endpointUri'] . '/v2';
        $token = 'YYY0987654321ZZZ';

        $gateway = $this->getUserGateway($client, $uri, $token);

        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\Gateway);
        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\UserGateway);

        $this->assertAttributeEquals($client, 'client', $gateway);
        $this->assertAttributeEquals($uri, 'requestUri', $gateway);
        $this->assertAttributeEquals($token, 'token', $gateway);

    }

    public function testGetUser()
    {

        $client = new \TheTwelve\Foursquare\HttpClient\StubHttpClient();
        $uri = $_GET['endpointUri'] . '/v2';
        $token = 'YYY0987654321ZZZ';

        $gateway = $this->getUserGateway($client, $uri, $token);

        $id = 11587764;
        $firstName = 'Justin';
        $lastName = 'Mazur';
        $relationship = 'self';

		$expectedResponse = array(
		    'response' => array(
		    	'user' => array(
                    'id' => $id,
		            'firstName' => $firstName,
		            'lastName' => $lastName,
		            'relationship' => $relationship,
		        )
		    )
		);

		$client->setExpectedResponse(json_encode($expectedResponse));

        $user = $gateway->getUser();

        $this->assertTrue($user instanceof stdClass);
        $this->assertEquals($id, $user->id);
        $this->assertEquals($firstName, $user->firstName);
        $this->assertEquals($lastName, $user->lastName);
        $this->assertEquals($relationship, $user->relationship);

    }

    public function testGetCheckins()
    {

        $client = new \TheTwelve\Foursquare\HttpClient\StubHttpClient();
        $uri = $_GET['endpointUri'] . '/v2';
        $token = 'YYY0987654321ZZZ';

        $gateway = $this->getUserGateway($client, $uri, $token);

        $id = "4e270befae609b2f94ed0546";
        $createdAt = 1311181807;
        $type = "checkin";
        $shout = "Food";
        $timeZoneOffset = -240;

        $expectedResponse = array(
            'response' => array(
                'checkins' => array(
                    'count' => 1,
                    'items' => array(
                        array(
                            'id' => $id,
                            'createdAt' => $createdAt,
                            'type' => $type,
                            'shout' => $shout,
                            'timeZoneOffset' => $timeZoneOffset,
                        )
                    )
                )
            )
        );

        $client->setExpectedResponse(json_encode($expectedResponse));

        $checkins = $gateway->getCheckins();

        $this->assertEquals(1, count($checkins));
        $this->assertTrue(array_key_exists(0, $checkins));

        $checkin = $checkins[0];

        $this->assertEquals($id, $checkin->id);
        $this->assertEquals($createdAt, $checkin->createdAt);
        $this->assertEquals($type, $checkin->type);
        $this->assertEquals($shout, $checkin->shout);
        $this->assertEquals($timeZoneOffset, $checkin->timeZoneOffset);

    }

    protected function getUserGateway($client, $uri, $token)
    {

        $gateway = new \TheTwelve\Foursquare\UserGateway($client);
        $gateway->setRequestUri($uri);
        $gateway->setToken($token);

        return $gateway;

    }

}
