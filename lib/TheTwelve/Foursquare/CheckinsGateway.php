<?php

namespace TheTwelve\Foursquare;

class CheckinsGateway extends EndpointGateway
{
	/**
     * Check a user to a venue, and maybe to a event too.
     * @param string $venueId
     * @param string $shout
     * @param array $options
     * @return object https://developer.foursquare.com/docs/responses/checkin
     * @see https://developer.foursquare.com/docs/checkins/add
     */
    public function checkin($venueId, $shout, array $options = array())
    {
        $resource = '/checkins/add';

        $response = $this->makeApiRequest($resource, compact('venueId','shout') + $options, 'POST');

        return $response;
    }
    
   /**
    * Returns a list of recent checkins from friends.
    * @param array $options
    * @return object https://developer.foursquare.com/docs/responses/checkin
    * @see https://developer.foursquare.com/docs/checkins/recent
    */
   public function getRecent(array $options = array())
   {
   	$resource = '/checkins/recent';
	$response = $this->makeAuthenticatedApiRequest($resource,$options);
	return $response;
   }    

    
    
    
}
