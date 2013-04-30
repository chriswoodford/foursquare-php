<?php

namespace TheTwelve\Foursquare;

interface Redirector
{

    /**
     * rediect to the supplied uri
     * @param string $uri
     * @return mixed
     */
    public function redirect($uri);

}
