<?php

namespace TheTwelve\Foursquare;

class VenuesGateway extends EndpointGateway
{
    /**
     * Enter description here ...
     * @param string $venueId
     * @return object
     */
    public function getVenue($venueId)
    {
        $resource = '/venues/' . $venueId;
        $response = $this->makeApiRequest($resource);

        return $response->venue;
    }

    public function add()
    {

    }

    /**
     * Returns a hierarchical list of categories applied to venues.
     * When designing client applications, please download this list
     * only once per session, but also avoid caching this data for
     * longer than a week to avoid stale information.
     * @return array
     */
    public function categories()
    {
        $resource = '/venues/categories';
        $response = $this->makeApiRequest($resource);

        return $response->categories;
    }

    public function explore()
    {}

    /**
     * Get a list of venues the current user manages.
     * @return array
     */
    public function managed()
    {
        $resource = '/venues/managed';
        $response = $this->makeApiRequest($resource);

        return $response->venues;
    }
    
    /**
     * Returns a list of venues near the current location, optionally matching a search term.
     * @see https://developer.foursquare.com/docs/venues/search
     * @param array $params
     * @return array
     */
    public function search(array $params = array())
    {
        $resource = '/venues/search';
        $response = $this->makeApiRequest($resource, $params);

        return $response->venues;
    }

    public function suggestCompletion()
    {}

    public function trending()
    {}

    /**
     * Allows you to access information about the current events at a place.
     * @param string $venueId
     * @return array
     */
    public function events($venueId)
    {

        $resource = '/venues/' . $venueId . '/events';
        $response = $this->makeApiRequest($resource);

        return $response->events->items;

    }

    public function hereNow()
    {}

    /**
     * Returns hours for a venue.
     * @param string $venueId
     * @return array
     */
    public function hours($venueId)
    {

        $resource = '/venues/' . $venueId . '/hours';
        $response = $this->makeApiRequest($resource);

        return $response->hours;

    }

    /**
     * Returns friends and a total count of users who have liked this venue.
     * @param string $venueId
     * @return array
     */
    public function likes($venueId)
    {

        $resource = '/venues/' . $venueId . '/likes';
        $response = $this->makeApiRequest($resource);

        return $response->likes;

    }

    public function links()
    {}

    public function lists()
    {}

    public function menu()
    {}

    public function photos()
    {}

    public function similar()
    {}

    public function stats()
    {}

    public function tips()
    {}

    public function edit()
    {}

    public function flag()
    {}

    public function like()
    {}

    public function markToDo()
    {}

    public function proposeEdit()
    {}

}
