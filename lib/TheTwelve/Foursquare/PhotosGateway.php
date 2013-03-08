<?php

namespace TheTwelve\Foursquare;

class PhotosGateway extends EndpointGateway
{

	/**
     * Check a user to a photo, and maybe to a event too.
     * @param string $venueId
     * @return object https://developer.foursquare.com/docs/responses/photo
     * @see https://developer.foursquare.com/docs/photos/photos
     */
    public function getPhoto($photoId)
    {

        $resource = '/photos/' . $photoId;
        $response = $this->makeApiRequest($resource);
        return $response->photo;

    }

	/**
     * Check a user to a venue, and maybe to a event too.
     * @param string $venueId
     * @return object https://developer.foursquare.com/docs/responses/photo
     * @see https://developer.foursquare.com/docs/photos/add
     */
    public function addPhoto($options)
    {

        $resource = '/photos/add';
        $response = $this->makeApiRequest($resource, $options, 'POST');
        return $response->photo;

    }

}
