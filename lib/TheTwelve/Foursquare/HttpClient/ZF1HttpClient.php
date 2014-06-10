<?php

namespace TheTwelve\Foursquare\HttpClient;

class Zend1HttpClient extends HttpClientAdapter
{

    protected $_client;

    public function __construct( $client )
    {
        $this->_client = $client;
    }

    /**
     * (non-PHPdoc)
     * @see \TheTwelve\Foursquare.HttpClient::get()
     * 
     * @param string $uri
     * @param array $params
     * @return string|null|boolean
     */
    public function get( $uri, array $params = array() )
    {
        $this->_client->setMethod('GET');
        return $this->_request($uri, $params);
    }

    /**
     * (non-PHPdoc)
     * @see TheTwelve\Foursquare.HttpClient::post()
     * 
     * @param string $uri
     * @param array $params
     * @return string|null|boolean
     */
    public function post( $uri, array $params = array() )
    {
        $this->_client->setMethod('POST');
        return $this->_request($uri, $params);
    }

    /**
     * Process request
     * 
     * @param string $uri
     * @param array $params
     * @return string|null|boolean
     */
    protected function _request( $uri, array $params = array() )
    {
        $this->_client->setUri($uri);
        $this->_client->setParameterGet($params);

        try {
            $response = $this->_client->request();
        } catch (Exception $e) {
            return null;
        }

        if ( $response->getStatus() != 200 ) {
            return false;
        }

        return $response->getBody();
    }

}
