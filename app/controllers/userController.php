<?php 
use Slim\Http\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
require_once __DIR__ .'/../models/userModel.php';
class UserController 
{
    private $email;
    private $password;
    public function createUser(Request $request, Response $response) {
        
        $errors = array();
        $data = $request->getParsedBody();
        $email = $data["email"];
        $password = $data["password"];

        try {
            $this->email = $this->checkEmail($email);
        } catch (Exception $e) {
            $errors['emailErr'] = json_decode($e->getMessage());
        }

        try {
            $this->password = $this->checkPassword($password);
        } catch (Exception $e) {
            
            $errors['passwordErr'] = json_decode($e->getMessage());
        }
        
        if($this->email && $this->password){
            $userFactory = new UserModel;
            $errors["databaseError"] = $userFactory->createUser($this->email, $this->password);

        }
        
        // if()
        return $response->withJson($errors);
    }

    public function login(Request $request, Response $response) {
        $errors = array();
        $data = $request->getParsedBody();
        $email = $data["email"];
        $password = $data["password"];

        try {
            $this->email = $this->checkEmail($email);
        } catch (Exception $e) {
            $errors['emailErr'] = json_decode($e->getMessage());
        }

        try {
            $this->password = $this->checkPassword($password);
        } catch (Exception $e) {
            $errors['passwordErr'] = json_decode($e->getMessage());
        }

        if($this->email && $this->password){
            $userFactory = new UserModel;
            $errors["databaseError"] = $userFactory->createUser($this->email, $this->password);

        }
    }

    private function checkEmail(string $email): string
    {
        $email = trim($email);
        $email = stripslashes($email);
        $email = htmlspecialchars($email);
        if(!$email){

            throw new Exception(json_encode("Email is required"));

        } else {
            
            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

                return $email;

            }
            else throw new Exception('Invalid Email');
        }
    }

    private function checkPassword(string $password): array|string
    {
        $password = trim($password);
        $password = stripslashes($password);
        $password = htmlspecialchars($password);
        if(!$password){

            throw new Exception(json_encode("Password is required"));
    
        }
        
        $errorMsgs = [];

        if (!preg_match("/^.{8,256}$/", $password)) {
            array_push($errorMsgs, 'Password length must be 8 or more');
        }

        if (!preg_match("/^(?=.*[a-z]).*$/", $password)) {
            array_push($errorMsgs, "Must have a lowercase character");
        }

        if (!preg_match("/^(?=.*[A-Z]).*$/", $password)) {
            array_push($errorMsgs, "Must have a uppercase character");
        }

        if (!preg_match("/^(?=.*\d).*$/", $password)) {
            array_push($errorMsgs, "Must have a number");
        }

        if (!preg_match("/^(?=.*(\W|_)).*$/", $password)) {
            array_push($errorMsgs, "Must have a special symbol");
        }
        if(!empty($errorMsgs)) throw new Exception(json_encode($errorMsgs));
        return $password;
    }

}
