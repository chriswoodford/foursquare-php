<?php

class TheTwelve_Foursquare_UsersGatewayTest
    extends PHPUnit_Framework_TestCase
{

    public function testProperties()
    {

        $client = $this->getMockForAbstractClass(
        	'TheTwelve\Foursquare\HttpClient'
        );

        $uri = $_GET['endpointUri'] . '/v2';
        $token = 'YYY0987654321ZZZ';
        $userId = '1234567654321';

        $gateway = $this->createUserGateway($client, $uri, $token);
        $gateway->setUserId($userId);

        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\EndpointGateway);
        $this->assertTrue($gateway instanceof \TheTwelve\Foursquare\UsersGateway);

        $this->assertAttributeEquals($client, 'client', $gateway);
        $this->assertAttributeEquals($uri, 'requestUri', $gateway);
        $this->assertAttributeEquals($token, 'token', $gateway);

        $this->assertAttributeEquals($userId, 'userId', $gateway);

    }

    public function testGetUser()
    {

        $uri = $_GET['endpointUri'] . '/v2';
        $token = 'YYY0987654321ZZZ';

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

        $client = $this->getMockForAbstractClass(
        	'TheTwelve\Foursquare\HttpClient'
        );

        $client->expects($this->any())
               ->method('get')
               ->will($this->returnValue(json_encode($expectedResponse)));

        $gateway = $this->createUserGateway($client, $uri, $token);
        $user = $gateway->getUser();

        $this->assertTrue($user instanceof stdClass);
        $this->assertEquals($id, $user->id);
        $this->assertEquals($firstName, $user->firstName);
        $this->assertEquals($lastName, $user->lastName);
        $this->assertEquals($relationship, $user->relationship);

    }

	/**
     * @expectedException    RuntimeException
     */
    public function testUserGatewayWithNoToken()
    {

        $uri = $_GET['endpointUri'] . '/v2';
        $token = 'YYY0987654321ZZZ';
        $client = $this->getMockForAbstractClass(
        	'TheTwelve\Foursquare\HttpClient'
        );

        $gateway = $this->createUserGateway($client, $uri, $token);
        $gateway->setToken(null);

        $user = $gateway->getUser();

    }

    public function testGetLeaderboard()
    {

    }

    public function testGetRequests()
    {

    }

    public function testGetSearch()
    {

    }

    public function testGetBadges()
    {

    }

    public function testGetCheckins()
    {

        $uri = $_GET['endpointUri'] . '/v2';
        $token = 'YYY0987654321ZZZ';

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

        $client = $this->getMockForAbstractClass(
        	'TheTwelve\Foursquare\HttpClient'
        );

        $client->expects($this->any())
               ->method('get')
               ->will($this->returnValue(json_encode($expectedResponse)));

        $gateway = $this->createUserGateway($client, $uri, $token);
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

    public function testGetFriends()
    {

        $uri = $_GET['endpointUri'] . '/v2';
        $token = 'YYY0987654321ZZZ';

        $id = '3130852';
        $firstName = 'Chris';
        $lastName = 'Woodford';
        $relationship = 'friend';
        $gender = 'male';
        $homeCity = 'Toronto, Canada';

        $expectedResponse = array(
            'response' => array(
                'friends' => array(
                    array(
                        'id' => $id,
                        'firstName' => $firstName,
                        'lastName' => $lastName,
                        'relationship' => $relationship,
                        'gender' => $gender,
                        'homeCity' => $homeCity,
                    ),
                )
            )
        );

        $client = $this->getMockForAbstractClass(
        	'TheTwelve\Foursquare\HttpClient'
        );

        $client->expects($this->any())
               ->method('get')
               ->will($this->returnValue(json_encode($expectedResponse)));

        $gateway = $this->createUserGateway($client, $uri, $token);
        $friends = $gateway->getFriends();

        $this->assertEquals(1, count($friends));
        $this->assertTrue(array_key_exists(0, $friends));

        $friend = $friends[0];

        $this->assertEquals($id, $friend->id);
        $this->assertEquals($firstName, $checkin->firstName);
        $this->assertEquals($lastName, $checkin->lastName);
        $this->assertEquals($relationship, $checkin->relationship);
        $this->assertEquals($gender, $checkin->gender);
        $this->assertEquals($homeCity, $checkin->homeCity);

    }

    public function testGetLists()
    {

    }

    public function testGetMayorships()
    {

    }

    public function testGetPhotos()
    {

    }

    public function getVenueHistory()
    {

    }

    protected function createUserGateway($client, $uri, $token)
    {

        $gateway = new \TheTwelve\Foursquare\UsersGateway($client);
        $gateway->setRequestUri($uri);
        $gateway->setToken($token);

        return $gateway;

    }

}
