<?php

namespace TheTwelve\Foursquare;

class ClientGateway extends Gateway
{

    /**
     * factory method for user gateway
     * @return TheTwelve\Foursquare\UserGateway
     */
    public function getUserGateway()
    {

        $gateway = new UserGateway($this->client);
        $gateway->setToken($this->token);
        return $gateway;


    }

}
