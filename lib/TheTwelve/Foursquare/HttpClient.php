<?php

namespace TheTwelve\Foursquare;

interface HttpClient
{


    /**
     * rediect to the supplied uri
     * @param string $uri
     * @return mixed
     */
    public function redirect($uri);

}
