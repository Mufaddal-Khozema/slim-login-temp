<?php
session_start(); 
use Slim\Factory\AppFactory;
use Psr\Container\ContainerInterface;
use DI\ContainerBuilder;

use League\OAuth2\Client\Provider\Facebook;
use League\OAuth2\Client\Provider\Google;
use Slim\Views\Twig;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/db/db_conn.php';
$config = require_once __DIR__ . '/config.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    'config' => $config,
    'view' => function() {
        return Twig::create('/');
    },
    Facebook::class => function(ContainerInterface $c) {
        $config = $c->get('config'); 
        $clientId = $config['facebook']['clientId']; 
        $clientSecret = $config['facebook']['clientSecret'];
    
        return new Facebook([
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'redirectUri' => 'http://localhost/slim-login/login/facebook/callback',
            'graphApiVersion' => 'v2.10'
        ]);
    },
    Google::class => function(ContainerInterface $c) {
        $config = $c->get('config'); 
        $clientId = $config['google']['clientId']; 
        $clientSecret = $config['google']['clientSecret'];

        return new Google([
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'redirectUri' => 'http://localhost/slim-login/login/google/callback',
        ]);
    }
]);
$container = $containerBuilder->build();


AppFactory::setContainer($container);
$app = AppFactory::create();


$routes = require __DIR__ . '/app/lib/routes.php';
$routes($app);

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->run();