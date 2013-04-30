<?php

namespace TheTwelve\Foursquare\Redirector;

use TheTwelve\Foursquare,
    Symfony\Component\HttpFoundation;

class SymfonyRedirector implements Foursquare\Redirector
{

    /**
     * (non-PHPdoc)
     * @see TheTwelve\Foursquare.Redirector::redirect()
     */
    public function redirect($uri)
    {

        $response = new HttpFoundation\RedirectResponse($uri);
        $response->sendHeaders();
        return $response;

    }

}
