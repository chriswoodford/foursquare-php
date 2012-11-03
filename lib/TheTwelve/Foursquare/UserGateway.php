<?php

namespace TheTwelve\Foursquare;

class UserGateway extends Gateway
{

    /** @var string */
    protected $userId;

    public function __construct(HttpClient $client)
    {

        parent::__construct($client);

        $this->userId = 'self';

    }

    /**
     * set the user id
     * @param string $id
     */
    public function setUserId($id)
    {

        $this->userId = $id;

    }

    /**
     * get a user
     * @see https://developer.foursquare.com/docs/users/users
     * @return stdClass
     */
    public function getUser()
    {

        $uri = '/users/' . $this->userId;
        $response = $this->makeApiRequest($uri);

        return $response->user;

    }

    /**
     * Returns a history of checkins for the authenticated user.
     * @see https://developer.foursquare.com/docs/users/checkins
     * @param array $options
     * @return array
     */
    public function getCheckins(array $options = array())
    {

        $uri = '/users/' . $this->userId . '/checkins';
        $response = $this->makeApiRequest($uri, $options);

        return $response->checkins->items;

    }

}
