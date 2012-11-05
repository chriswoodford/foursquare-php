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
    {}

    /**
     * Shows a user the list of users with whom they have a pending friend
     * request (i.e., someone tried to add the acting user as a friend, but
     * the acting user has not accepted).
     * @see https://developer.foursquare.com/docs/users/requests
     */
    public function getRequests()
    {}

    /**
     * Helps a user locate friends.
     * @see https://developer.foursquare.com/docs/users/search
     */
    public function search()
    {}

    /**
     * Returns badges for a given user.
     * @see https://developer.foursquare.com/docs/users/badges
     */
    public function getBadges()
    {}

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

    /**
     * Returns an array of a user's friends.
     * @see https://developer.foursquare.com/docs/users/friends
     */
    public function getFriends()
    {}

    /**
     * A User's Lists.
     * @see https://developer.foursquare.com/docs/users/lists
     */
    public function getLists()
    {}

    /**
     * Returns a user's mayorships.
     * @see https://developer.foursquare.com/docs/users/mayorships
     */
    public function getMayorships()
    {}

    /**
     * Returns photos from a user.
     * @see https://developer.foursquare.com/docs/users/photos
     */
    public function getPhotos()
    {}

    /**
     * Returns a list of all venues visited by the specified user, along with
     * how many visits and when they were last there.
     * @see https://developer.foursquare.com/docs/users/venuehistory
     */
    public function getVenueHistory()
    {}

}
