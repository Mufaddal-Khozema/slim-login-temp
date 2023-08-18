<?php 
namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PageController {
    private $view;
    public function __construct(ContainerInterface $container) {
        $this->view = $container->get('view'); 
    }

    public function home(Request $request, Response $response) { 
        return $this->view->render($response, "App/views/index.twig"); 
    }

    public function login(Request $request, Response $response) { 
        return $this->view->render($response, "App/views/login.twig"); 
    }

    public function signup(Request $request, Response $response) { 
        return $this->view->render($response, "App/views/signup.twig");
    }

    // public function signupAdditional(Request $request, Response $response) {
    //     if(isset($_SESSION['user'])){
    //         return $this->view->render($response, "signup-additional.twig", ['user' => $_SESSION['user']]);
    //         // $response->getBody()->write('<pre>' . var_export($_SESSION['user'], true) . '</pre>');
    //         // return $response;
    //     }
    // }

    public function welcome(Request $request, Response $response) { 
        return $this->view->render($response, "App/views/marketplace.html"); 
    }
}