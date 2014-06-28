<?php

namespace TheTwelve\Foursquare;

class VenuesGateway extends EndpointGateway
{
    /**
     * Get venue by ID
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

        if(property_exists($response, 'categories')) {
            return $response->categories;
        }

        return array();
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

        if(property_exists($response, 'venues')) {
            return $response->venues;
        }
        
        return array();
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

        if(property_exists($response, 'venues')) {
            return $response->venues;
        }
        
        return array();
    }

    /**
     * Returns a list of mini-venues partially matching the search term, near the location.
     * @see https://developer.foursquare.com/docs/venues/suggestcompletion
     * @param array $params
     * @return array
     */
    public function suggestCompletion(array $params = array())
    {
        $resource = '/venues/suggestcompletion';
        $response = $this->makeApiRequest($resource, $params);

        if(property_exists($response, 'minivenues')) {
            return $response->minivenues;
        }

        return array();
    }

    /**
     * Get daily venue stats for a list of venues over a time range.
     * User must be venue manager.
     * @see https://developer.foursquare.com/docs/venues/timeseries
     * @param array $params
     * @return array
     */
    public function timeSeries(array $params = array())
    {
        $resource = '/venues/timeseries';
        $response = $this->makeApiRequest($resource, $params);

        if(property_exists($response, 'timeseries')) {
            return $response->timeseries;
        }

        return array();
    }

    /**
     * Returns a list of venues near the current location with the most people currently checked in.
     * @see https://developer.foursquare.com/docs/venues/trending
     * @param array $params
     * @return array
     */
    public function trending(array $params = array())
    {
        $resource = '/venues/trending';
        $response = $this->makeApiRequest($resource, $params);

        if(property_exists($response, 'venues')) {
            return $response->venues;
        }

        return array();
    }

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
