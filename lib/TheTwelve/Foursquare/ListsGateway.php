<?php

namespace TheTwelve\Foursquare;

class ListsGateway extends EndpointGateway
{
    /**
     * @var null|string
     */
    private $listId = null;

    /**
     * set the list id
     * @param string $id
     */
    public function setListId($id)
    {
        $this->listId = $id;
    }

    /**
     * Get a List.
     * @see https://developer.foursquare.com/docs/lists/lists
     * @param array $options
     */
    public function getList(array $options = array())
    {
        $uri = $this->buildListResourceUri($this->listId);
        $response = $this->makeApiRequest($uri, $options);
        return $response->list;
    }

    /**
     * build the resource URI
     * @param string $listId
     * @param string $resource
     * @return string
     */
    protected function buildListResourceUri($listId, $resource = '')
    {
        return '/lists/' . $listId . '/' . $resource;
    }
}
