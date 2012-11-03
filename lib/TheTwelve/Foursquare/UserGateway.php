<?php

namespace TheTwelve\Foursquare;

class UserGateway extends Gateway
{

    /** @var string */
    protected $userId;

    /**
     * set the user id
     * @param string $id
     */
    public function setUserId($id)
    {

        $this->userId = $id;

    }

    /**
     * Returns a history of checkins for the authenticated user.
     * @see https://developer.foursquare.com/docs/users/checkins
     * @param array $options
     * @return array
     */
    public function getCheckins(array $options = array())
    {

    }

}
