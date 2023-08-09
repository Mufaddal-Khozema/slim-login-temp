<?php 
namespace App\Controllers;
use Slim\Http\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\UserModel;
use \League\OAuth2\Client\Provider\Facebook;
class UserController 
{
    private $email;
    private $password;
    private $profile_picture;
    private $router;

    public function createUser(Request $request, Response $response) {
        
        $errors = array();
        $data = $request->getParsedBody();
        $email = $data["email"];
        $password = $data["password"];

        try {
            $this->email = $this->checkEmail($email);
        } catch (\Exception $e) {
            $errors['emailErr'] = json_decode($e->getMessage());
        }

        try {
            $this->password = $this->checkPassword($password);
        } catch (\Exception $e) {
            
            $errors['passwordErr'] = json_decode($e->getMessage());
        }
        
        $files = $request->getUploadedFiles();
        $profile_picture = $files['profile_picture'];

        try {
            $this->profile_picture = $this->checkImage($profile_picture);
        } catch (\Exception $e) {
            $errors['imageErr'] = $e->getMessage();
        }
        
        if($this->email && $this->password && $this->profile_picture){
            try {
                $userFactory = new UserModel;
                $userFactory->createUser($this->email, $this->password);
            } catch (\PDOException $e) {
                $errors["databaseError"] = $e->getMessage();
            } catch (\Exception $e) {
                $errors["databaseError"] = $e->getMessage();
            }
        }
        
        if(empty($errors)) {
            return $response->withJson("success");    
        }
        return $response->withJson(array("error" =>$errors));
    }

    public function loginUser(Request $request, Response $response) {
        
        $errors = array();
        $data = $request->getParsedBody();
        $email = $data["email"];
        $password = $data["password"];
        
        
        try {
            $this->email = $this->checkEmail($email);
        } catch (\Exception $e) {
            $errors['emailErr'] = json_decode($e->getMessage());
        }

        try {
            $this->password = $this->checkPassword($password);
        } catch (\Exception $e) {
            $errors['passwordErr'] = json_decode($e->getMessage());
        }

        if($this->email && $this->password){
            try {
                $userFactory = new UserModel;
                $userFactory->loginUser($this->email, $this->password);
            } catch (\PDOException $e) {
                $errors["databaseError"] = $e->getMessage();
            } catch (\Exception $e) {
                $errors["databaseError"] = $e->getMessage();
            }
        }

        if(empty($errors)) {
            return $response->withJson("success");    
        }
        return $response->withJson(array("error" =>$errors));
    }

    public function facebookLogin(Request $request, Response $response){
        $provider = new Facebook([
            'clientId' => '1247168906001105',
            'clientSecret' => '68a7c33119052298ee6bd705cbbc35ce',
            'redirectUri' => 'http://localhost/facebookOAuth-2/',
            'graphApiVersion' => 'v2.10'
        ]);
    }
    private function checkEmail(string $email): string
    {
        $email = trim($email);
        $email = stripslashes($email);
        $email = htmlspecialchars($email);
        if(!$email){

            throw new \Exception(json_encode("Email is required"));

        } else {
            
            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

                return $email;

            }
            else throw new \Exception(json_encode('Invalid Email'));
        }
    }

    private function checkPassword(string $password): array|string
    {
        $password = trim($password);
        $password = stripslashes($password);
        $password = htmlspecialchars($password);
        if(!$password){

            throw new \Exception(json_encode("Password is required"));
    
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
        if(!empty($errorMsgs)) throw new \Exception(json_encode($errorMsgs));
        return $password;
    }
    private function checkImage($profile_picture)
    {
        if(!isset($profile_picture)){
            throw new \Exception('No Profile Picture Provided');
        } else {
            $targetPath = 'uploads/' . $profile_picture->getClientFileName();
            $profile_picture->moveTo($targetPath);
            $profileType = getimagesize($targetPath) ? getimagesize($targetPath)['mime'] :getimagesize($targetPath);
    
            $validImageTypes = array('image/jpg', 'image/jpeg', 'image/png');
            if(in_array($profileType, $validImageTypes)){
                
            };
            return $profile_picture;
        }
    }
}
