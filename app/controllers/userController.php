<?php 
namespace App\Controllers;
use Slim\Http\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use App\Models\UserModel;
use \League\OAuth2\Client\Provider\Facebook;
require_once __DIR__ . '/../../config.php';
class UserController 
{
    private $profile_picture;
    private $config;
    private $facebook;

    public function __construct(ContainerInterface $container){
        $this->config = $container->get('config');
        $this->facebook = $container->get(Facebook::class);
    }

    public function createUser(Request $request, Response $response) {
        
        $errors = array();
        $data = $request->getParsedBody();
        $email = $this->cleaner($data["email"]);
        $password = $this->cleaner($data["password"]);

        if(!$email || !$this->validateEmail($email)){
            $errors["email"] = $email? "Invalid email" : "Email is required";
        }
        if(!$password || !$this->validatePassword($password)){
            $errors["password"] = $password? "Invalid password" : "Password is required";
        }

        $files = $request->getUploadedFiles();
        $profile_picture = $files['profile_picture'];

        if(!$profile_picture || !$this->validateImage($profile_picture)){
            $errors["profile_picture"] = "Profile picture is required";
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
        $email = $this->cleaner($data["email"]);
        $password = $this->cleaner($data["password"]);

        if(!$email){
            $errors['emailErr'] = "Email is required";
        } else if(!$this->validateEmail($email)) {
            $errors['emailErr'] = "Invalid email";
        }
        if(!$password){
            $errors['passwordErr'] = "Password is required";
        } else if(!$this->validatePassword($password)){
            $errors['passwordErr'] = "Invalid password";
        }
        
        if(!empty($errors)) {
            return $response->withJson($errors);
        }

        try {
            $userFactory = new UserModel;
            $userFactory->loginUser($email, $password);
        } catch (\PDOException $e) {
            $errors["databaseError"] = $e->getMessage();
        } catch (\Exception $e) {
            $errors["databaseError"] = $e->getMessage();
        }
        if(empty($errors)) {
            return $response->withJson("success");
        }else return $response->withJson(array("error" =>$errors));
    }

    public function facebookLogin(Request $request, Response $response){
        $provider = $this->facebook;
        $authUrl = $provider->getAuthorizationUrl(['scope' => ['email']]);
        $_SESSION['oauth2state'] = $provider->getState();
        return $response->withRedirect($authUrl, 302);
    }

    public function facebookLoginCallback(Request $request, Response $response){
        $provider = $this->facebook;
        $queryParams = $request->getQueryParams();
        if(empty($queryParams['state']) || $queryParams['state'] !== $_SESSION['oauth2state']){
                return $response->withStatus(401)->getBody()->write('Authorization state mismatch');
        }
        $token = $provider->getAcessToken('authorization_code', [
            'code' => $queryParams['code']
        ]);

    }

    private function cleaner(string $dirty){
        $dirty = trim($dirty);
        $dirty = stripslashes($dirty);
        $clean = htmlspecialchars($dirty);
        return $clean;
    }

    private function validateEmail(string $email): bool{
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else return false;
    }

    private function validatePassword(string $password): array|string{
        if(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(\W|_)).*$/', $password)){
            return true;
        } else return false;
    }
    private function checkImage($profile_picture){
        
        $profileType = getimagesize($targetPath) ? getimagesize($targetPath)['mime'] :getimagesize($targetPath);
        $validImageTypes = array('image/jpg', 'image/jpeg', 'image/png');
        if(in_array($profileType, $validImageTypes)){
        };
        return $profile_picture;
        // $targetPath = 'uploads/' . $profile_picture->getClientFileName();
        // $profile_picture->moveTo($targetPath);
    
                
        
    }
}
