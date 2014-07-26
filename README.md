# Foursquare API Client

A(nother) PHP Foursquare API client
[https://developer.foursquare.com/docs/](https://developer.foursquare.com/docs/)

## Installation

[Composer](http://getcomposer.org) is currently the only way to install the
foursquare client into your project.

### Create your composer.json file

      {
          "require": {
              "thetwelvelabs/foursquare": "0.2.*"
          }
      }

### Download composer into your application root

      $ curl -s http://getcomposer.org/installer | php

### Install your dependencies

      $ php composer.phar install

## Usage

### Select your preferred HTTP Client (CurlHttpClient is the default)

      $client = new \TheTwelve\Foursquare\HttpClient\CurlHttpClient($pathToCertificateFile);

### Select your preferred Redirector (HeaderRedirector is the default)

      $redirector = new \TheTwelve\Foursquare\Redirector\HeaderRedirector();

Note: The redirector is optional and is only needed if you need Foursquare authentication

### Instantiate the API Gateway Factory

      $factory = new \TheTwelve\Foursquare\ApiGatewayFactory($client, $redirector);

      // Required for most requests
      $factory->setClientCredentials('CLIENT_ID', 'CLIENT_SECRET');

      // Optional (only use these if you know what you're doing)
      $factory->setEndpointUri('https://api.foursquare.com');
      $factory->useVersion(2);
      $factory->verifiedOn(new \DateTime());

### Begin authentication with Foursquare

      $auth = $factory->getAuthenticationGateway(
          'https://foursquare.com/oauth2/authorize',
          'https://foursquare.com/oauth2/access_token',
          'YOUR_REDIRECT_URL'
      );

      $auth->initiateLogin();

### Foursquare redirects the user back to you after a successful login

      $code = $_GET['code'];

      // You should do some input sanitization to $code here, just in case

      $token = $auth->authenticateUser($code);

### Update the API Gateway Factory with your OAuth token

      $factory->setToken($token);

### Get an instance of an endpoint gateway

      $gateway = $factory->getUsersGateway();

### Get data from Foursquare

      $user = $gateway->getUser();

### Search venues

      $gateway = $factory->getVenuesGateway();

      $venues = $gateway->search(array(
        'll' => '40.727198,-73.992289',
        'query' => 'Starbucks',
        'radius' => 1000,
        'intent' => 'checkin'
      ));

## Working With Symfony / Silex

If you're working with Symfony or Silex, you can use the Symfony HttpClient and Redirector

      $client = new \TheTwelve\Foursquare\HttpClient\SymfonyHttpClient($pathToCertificateFile);
      $redirector = new \TheTwelve\Foursquare\Redirector\SymfonyRedirector();

If you're working with Silex, there is a Service Provider available at
[https://github.com/chriswoodford/FoursquareServiceProvider](https://github.com/chriswoodford/FoursquareServiceProvider)

## Using the CurlHttpClient

If you're using the CurlHttpClient, you will probably want to include the cacert.pem file
that can be found at [http://curl.haxx.se/docs/caextract.html](http://curl.haxx.se/docs/caextract.html)

You can add this as a dependency in your composer file. Your `composer.json` might look something like this:

      {
          "require": {
              "thetwelvelabs/foursquare": "0.2.*",
              "haxx-se/curl": "1.0.0"
          },
          "repositories": [
              {
                  "type": "package",
                  "package": {
                      "name": "haxx-se/curl",
                      "version": "1.0.0",
                      "dist": {
                          "url": "http://curl.haxx.se/ca/cacert.pem",
                          "type": "file"
                      }
                  }
              }
          ]
      }

You will be able to find the cacert.pem file in `vendor/haxx-se/curl/cacert.pem`

## Contributing

See [CONTRIBUTING.md](https://github.com/chriswoodford/foursquare-php/blob/master/CONTRIBUTING.md)

## License

This library is released under the [MIT License](http://www.opensource.org/licenses/MIT).
