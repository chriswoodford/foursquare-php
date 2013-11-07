<?php

namespace TheTwelve\Foursquare;

class UsersGateway extends EndpointGateway
{

    /** @var string */
    protected $userId;

    /**
     * initialize the gateway
     * @param \TheTwelve\Foursquare\HttpClient $client
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
     * @return \stdClass
     */
    public function getUser()
    {

        $resource = '/users/' . $this->userId;
        $response = $this->makeAuthenticatedApiRequest($resource);
        return $response->user;

    }

    /**
     * Returns the user's leaderboard.
     * @see https://developer.foursquare.com/docs/users/leaderboard
     */
    public function getLeaderboard()
    {

        $resource = '/users/leaderboard';
        $response = $this->makeAuthenticatedApiRequest($resource);

        return $response->leaderboard->items;
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
        $response = $this->makeAuthenticatedApiRequest($resource);

        return $response->requests;

    }

    /**
     * Helps a user locate friends.
     * @see https://developer.foursquare.com/docs/users/search
     * @param array $options
     */
    public function search(array $options = array())
    {

        $resource = '/users/search';
        $response = $this->makeAuthenticatedApiRequest($resource);

        return $response->results;

    }

    /**
     * Returns badges for a given user.
     * @see https://developer.foursquare.com/docs/users/badges
     */
    public function getBadges()
    {

        $uri = $this->buildUserResourceUri('badges');
        $response = $this->makeAuthenticatedApiRequest($uri);

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
        $response = $this->makeAuthenticatedApiRequest($uri, $options);

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
        $response = $this->makeAuthenticatedApiRequest($uri, $options);

        return $response->friends->items;

    }

    /**
     * Returns an array of a user's tips.
     * @see https://developer.foursquare.com/docs/users/tips
     * @param array $options
     */
    public function getTips(array $options = array())
    {

        $uri = $this->buildUserResourceUri('tips');
        $response = $this->makeAuthenticatedApiRequest($uri, $options);

        return $response->tips->items;

    }

    /**
     * A User's Lists.
     * @see https://developer.foursquare.com/docs/users/lists
     * @param array $options
     */
    public function getLists(array $options = array())
    {

        $uri = $this->buildUserResourceUri('lists');
        $response = $this->makeAuthenticatedApiRequest($uri, $options);

        return $response->lists;

    }

    /**
     * Returns a user's mayorships.
     * @see https://developer.foursquare.com/docs/users/mayorships
     */
    public function getMayorships()
    {

        $uri = $this->buildUserResourceUri('mayorships');
        $response = $this->makeAuthenticatedApiRequest($uri);

        return $response->mayorships->items;

    }

    /**
     * Returns photos from a user.
     * @see https://developer.foursquare.com/docs/users/photos
     * @param array $options
     */
    public function getPhotos(array $options = array())
    {

        $uri = $this->buildUserResourceUri('photos');
        $response = $this->makeAuthenticatedApiRequest($uri);

        return $response->photos->items;

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
        $response = $this->makeAuthenticatedApiRequest($uri);

        return $response->venues->items;

    }

    /**
     * Approves a pending friend request from another user.
     * @param string $friendId
     * @return \stdClass
     */
    public function approve($friendId)
    {

        $uri = $this->buildUserResourceUri('approve', $friendId);
        $response = $this->makeAuthenticatedApiRequest($uri);

        return $response->user;

    }

    /**
     * Denies a pending friend request from another user.
     * @param string $friendId
     * @return \stdClass
     */
    public function deny($friendId)
    {

        $uri = $this->buildUserResourceUri('deny', $friendId);
        $response = $this->makeAuthenticatedApiRequest($uri);

        return $response->user;

    }

    /**
     * Sends a friend request to another user. If the other user is a page
     * then the requesting user will automatically start following the page.
     * @param string $friendId
     * @return \stdClass
     */
    public function request($friendId)
    {

        $uri = $this->buildUserResourceUri('request', $friendId);
        $response = $this->makeAuthenticatedApiRequest($uri);

        return $response->user;

    }

    /**
     * Cancels any relationship between the acting user and the specified user
     * Removes a friend, unfollows a celebrity, or cancels a pending friend
     * request.
     * @param string $friendId
     * @return \stdClass
     */
    public function unfriend($friendId)
    {

        $uri = $this->buildUserResourceUri('unfriend', $friendId);
        $response = $this->makeAuthenticatedApiRequest($uri);

        return $response->user;

    }

    /**
     * build the resource URI
     * @param string $resource
     * @param string|null $userId
     * @return string
     */
    protected function buildUserResourceUri($resource, $userId = null)
    {

        $userId = is_null($userId) ? $this->userId : $userId;
        return '/users/' . $userId . '/' . $resource;

    }

}
