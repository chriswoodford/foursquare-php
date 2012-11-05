<?php

namespace TheTwelve\Foursquare;

class UsersGateway extends EndpointGateway
{

    /** @var string */
    protected $userId;

    /**
     * initialize the gateway
     * @param TheTwelve\Foursquare\HttpClient $client
     */
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

        $resource = '/users/' . $this->userId;
        $response = $this->makeApiRequest($resource);

        return $response->user;

    }

    /**
     * Returns the user's leaderboard.
     * @see https://developer.foursquare.com/docs/users/leaderboard
     */
    public function getLeaderboard()
    {

        $resource = '/users/leaderboard';

    }

    /**
     * Shows a user the list of users with whom they have a pending friend
     * request (i.e., someone tried to add the acting user as a friend, but
     * the acting user has not accepted).
     * @see https://developer.foursquare.com/docs/users/requests
     */
    public function getRequests()
    {

        $resource = '/users/requests';

    }

    /**
     * Helps a user locate friends.
     * @see https://developer.foursquare.com/docs/users/search
     * @param array $options
     */
    public function search(array $options = array())
    {


    }

    /**
     * Returns badges for a given user.
     * @see https://developer.foursquare.com/docs/users/badges
     */
    public function getBadges()
    {

        $uri = $this->buildUserResourceUri('badges');
        $response = $this->makeApiRequest($uri);

        return $response->badges;

    }

    /**
     * Returns a history of checkins for the authenticated user.
     * @see https://developer.foursquare.com/docs/users/checkins
     * @param array $options
     * @return array
     */
    public function getCheckins(array $options = array())
    {

        $uri = $this->buildUserResourceUri('checkins');
        $response = $this->makeApiRequest($uri, $options);

        return $response->checkins->items;

    }

    /**
     * Returns an array of a user's friends.
     * @see https://developer.foursquare.com/docs/users/friends
     * @param array $options
     */
    public function getFriends(array $options = array())
    {

        $uri = $this->buildUserResourceUri('friends');
        $response = $this->makeApiRequest($uri, $options);

        return $response->friends->items;

    }

    /**
     * A User's Lists.
     * @see https://developer.foursquare.com/docs/users/lists
     * @param array $options
     */
    public function getLists(array $options = array())
    {

        $uri = $this->buildUserResourceUri('lists');
        $response = $this->makeApiRequest($uri, $options);

        return $response->lists;

    }

    /**
     * Returns a user's mayorships.
     * @see https://developer.foursquare.com/docs/users/mayorships
     * @param array $options
     */
    public function getMayorships()
    {

        $uri = $this->buildUserResourceUri('mayorships');
        $response = $this->makeApiRequest($uri);

        return $response->mayorships;

    }

    /**
     * Returns photos from a user.
     * @see https://developer.foursquare.com/docs/users/photos
     * @param array $options
     */
    public function getPhotos(array $options = array())
    {

        $uri = $this->buildUserResourceUri('photos');
        $response = $this->makeApiRequest($uri);

        return $response->photos;

    }

    /**
     * Returns a list of all venues visited by the specified user, along with
     * how many visits and when they were last there.
     * @see https://developer.foursquare.com/docs/users/venuehistory
     * @param array $options
     */
    public function getVenueHistory(array $options = array())
    {

        $uri = $this->buildUserResourceUri('venuehistory');
        $response = $this->makeApiRequest($uri);

        return $response->venues;

    }

    /**
     * build the resource URI
     * @param string $resource
     * @return string
     */
    protected function buildUserResourceUri($resource)
    {

        return '/users/' . $this->userId . '/' . $resource;

    }

}
