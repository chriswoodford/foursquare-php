<?php

namespace TheTwelve\Foursquare\Redirector;

use TheTwelve\Foursquare;

class HeaderRedirector implements Foursquare\Redirector
{

    /**
     * (non-PHPdoc)
     * @see TheTwelve\Foursquare.Redirector::redirect()
     */
    public function redirect($uri)
    {

        header('Location: ' . $uri);
        exit(0);

    }

}
