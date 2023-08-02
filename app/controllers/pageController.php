<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

class PageController {
    private $view;
    public function __construct() {
        $this->view = new PhpRenderer(__DIR__ . "/../views");
    }

    public function home(Request $request, Response $response) { 
        return $this->view->render($response, "index.php"); 
    }

    public function login(Request $request, Response $response) { 
        return $this->view->render($response, "Login/login.php"); 
    }

    public function signup(Request $request, Response $response) { 
        return $this->view->render($response, "Signup/signup.php");
    }
}