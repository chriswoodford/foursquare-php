<?php

namespace TheTwelve\Foursquare;

class VenuesGateway extends EndpointGateway
{

    /**
     * Enter description here ...
     * @param string $venueId
     * @return \stdClass
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

}
