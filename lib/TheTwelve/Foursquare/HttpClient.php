<?php

namespace TheTwelve\Foursquare;

interface HttpClient
{

    /**
     * make a get request to the given uri
     * @param string $uri
     * @param array $params
     * @return mixed
     */
    public function get($uri, array $params = array());

    /**
     * make a post request to the given uri
     * @param string $uri
     * @param array $params
     * @return mixed
     */
    public function post($uri, array $params = array());

    /**
     * rediect to the supplied uri
     * @param string $uri
     * @return mixed
     */
    public function redirect($uri);

}
