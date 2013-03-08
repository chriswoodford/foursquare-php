# Foursquare API Client by TheTwelve Labs

A(nother) PHP Foursquare API client  
[https://developer.foursquare.com/docs/](https://developer.foursquare.com/docs/)

## Installation

[Composer](http://getcomposer.org) is currently the only way to install the 
foursquare client into your project.

### Create your composer.json file

      {
          "require": {
              "thetwelvelabs/foursquare": "0.1.*@dev"
          }
      }

### Download composer into your application root

      $ curl -s http://getcomposer.org/installer | php

### Install your dependencies

      $ php composer.phar install

## Usage

### Select your preferred HTTP Client

      $client = new \TheTwelve\Foursquare\HttpClient\SymfonyHttpClient();

### Instantiate the API Gateway Factory

      $factory = new \TheTwelve\Foursquare\ApiGatewayFactory($client);
      
      // Required for most requests
      $factory->setClientCredentials('CLIENT_ID', 'CLIENT_SECRET');

      // Optional
      $factory->setEndpointUri('https://api.foursquare.com');
      $factory->useVersion(2);

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
      $token = $authGateway->authenticateUser($code);

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

## License

This library is released under the [MIT License](http://www.opensource.org/licenses/MIT).
