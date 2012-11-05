# foursquare-php by TheTwelve Labs
================================

A(nother) PHP Foursquare API client

[https://developer.foursquare.com/docs/](https://developer.foursquare.com/docs/)

## Installation
--------------

[Composer](http://getcomposer.org) is currently the only way to install the 
foursquare client into your project.

### Create your composer.json file

      {
          "require": {
              "thetwelvelabs/foursquare": "0.1.*"
          },
          "minimum-stability": "dev"
      }

### Download composer into your application root

      $ curl -s http://getcomposer.org/installer | php

### Install your dependencies

      $ php composer.phar install

## Usage
---------

### Select your preferred HTTP Client

      $client = new \TheTwelve\Foursquare\HttpClient\SymfonyHttpClient();

### Instantiate the API Gateway Factory

      $factory = new \TheTwelve\Foursquare\ApiGatewayFactory($client);
      $factory->setEndpointUri('https://api.foursquare.com');
      $factory->useVersion(2);

### Begin authenticate with Foursquare

      $auth = $factory->getAuthenticationGateway(
          'YOUR_CLIENT_ID',
          'YOUR_CLIENT_SECRET',
          'YOUR_REDIRECT_URL',
          'https://foursquare.com/oauth2/authorize',
          'https://foursquare.com/oauth2/access_token'
      );

      $auth->initiateLogin();

### Foursquare redirects user after successful login

      $code = $_GET['code'];
      $token = $authGateway->authenticateUser($code);

### Update the API Gateway Factory with your OAuth token

      $factory->setToken($token);

### Get an instance of an endpoint gateway

      $gateway = $factory->getUsersGateway();

### Get data from Foursquare

      $user = $gateway->getUser();
