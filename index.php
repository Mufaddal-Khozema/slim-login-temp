<?php
// session_start(); 
use Slim\Factory\AppFactory;
use League\OAuth2\Client\Provider\Facebook;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/db/db_conn.php';
use DI\ContainerBuilder;

$config = require_once __DIR__ . '/config.php';

$containerBuilder = new ContainerBuilder();
$container = $containerBuilder->build();

$container->set('config', $config);
$container->set(Facebook::class, function ($c) {
    $config = $c->get('config');
  
    $clientId = $config['clientId']; 
    $clientSecret = $config['clientSecret'];
   
    return new Facebook([
        'clientId' => $clientId,
        'clientSecret' => $clientSecret,
        'redirectUri' => 'http://localhost/facebook/login/callback',
        'graphApiVersion' => 'v2.10'
    ]);
});

AppFactory::setContainer($container);
$app = AppFactory::create();


$routes = require __DIR__ . '/app/lib/routes.php';
$routes($app);

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->run();