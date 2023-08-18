<?php 
namespace App\Controllers;

use Slim\Http\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use App\Models\UserModel;
use \League\OAuth2\Client\Provider\Facebook;
use League\OAuth2\Client\Provider\Google;
use RuntimeException;

class UserController 
{
    private $facebook;
    private $google;

    public function __construct(ContainerInterface $container){
        $this->facebook = $container->get(Facebook::class);
        $this->google = $container->get(Google::class);
    }

    public function signup(Request $request, Response $response){
        try {
            $data = $request->getParsedBody();
            $files = $request->getUploadedFiles();
            
            if (empty($data['user']) ) {
                throw new RuntimeException('User not provided');
            }

            if(empty($files['profile_picture']) || $files['profile_picture']->getError() !== UPLOAD_ERR_OK){
                throw new RuntimeException('Profile picture not provided');
            }

            $user = json_decode($data['user'],true);
            $image = $files['profile_picture'];
            $cleanedUser = array();
            
            $checklist = ['first_name', 'last_name', 'email', 'mobileno', 'street_address', 'city', 'province', 'zipcode', 'trade', 'skill', 'work_province', 'password'];
            $checklist = array_flip($checklist);
            foreach($user as $key => $value){
                if(isset($checklist[$key])){
                    unset($checklist[$key]);
                    if(empty($value)){
                        throw new RuntimeException('Value of' . $key . ' not provided');
                    }
                    $value = $this->cleaner($value);
                    $cleanedUser[$key] = ($key === 'mobileno' || $key === 'zipcode')? (int)$value : $value;
                }
            }

            if(!empty($checklist)) {
                throw new RuntimeException(implode(', ', $checklist) . ' not provided.');
            }
            
            if(!$this->validateUser($cleanedUser)){
                throw new RuntimeException('Not a valid user');
            }

            if(!$this->validateImage($image)){
                throw new RuntimeException('Not a valid image');
            }
            $extention = pathinfo($image->getClientFilename(), PATHINFO_EXTENSION);
            $basename = bin2hex(random_bytes(8));
            $filepath = sprintf("uploads/%s.%s",$basename,$extention);
            $image->moveTo($filepath);
            
            return $this->createUser($response, $cleanedUser, $filepath);
        } catch (RuntimeException $e){
            return $response->withJson(array('error' => $e->getMessage()));
        } 
    }

    public function createUser(Response $response, array $user, $image) {
        try {
            $userFactory = new UserModel();
            $token = $userFactory->createUser($user, $image);
            $_SESSION['auth'] = $token;
            return $response->withJson(array('message' => 'success'));
        } catch (\PDOException $e) {
            return $response->withJson(array('error' => $e->getMessage()));
        } catch (\RuntimeException $e) {
            return $response->withJson(array('error' => $e->getMessage()));
        }
    }

    public function loginUser(Request $request, Response $response) {
        try {
            $data = $request->getParsedBody();
            $email = $this->cleaner($data["email"]);
            $password = $this->cleaner($data["password"]);
    
            if(!$email){
                throw new RuntimeException("Email is required");
            } else if(!$this->validateEmail($email)) {
                throw new RuntimeException("Invalid email");
            }
    
            if(!$password){
                throw new RuntimeException("Password is required");
            } else if(!$this->validatePassword($password)){
                throw new RuntimeException("Invalid password");
            }
            
            $userFactory = new UserModel;
            $token = $userFactory->loginUser($email, $password);
            $_SESSION['auth'] = $token;
            return $response->withJson(array('message' => 'success'));

        } catch (RuntimeException $e){
            return $response->withJson(array('error' => $e->getMessage()));
        } catch (\PDOException $e) {
            return $response->withJson(array('error' => $e->getMessage()));
        } catch (\Exception $e) {
            return $response->withJson(array('error' => $e->getMessage()));
        }
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
            $response->getBody()->write('Authorization state mismatch');
            return $response->withStatus(401);
        }
        $token = $provider->getAccessToken('authorization_code', [
            'code' => $queryParams['code']
        ]);
        $user = $provider->getResourceOwner($token)->toArray();
        return $this->createUser($response, $user, $user['picture_url']);
    }

    public function googleLogin(Request $request, Response $response){
        $provider = $this->google;
        $authUrl = $provider->getAuthorizationUrl();
        $_SESSION['oauth2state'] = $provider->getState();
        return $response->withRedirect($authUrl, 302);
    }

    public function googleLoginCallback(Request $request, Response $response){
        $provider = $this->google;
        $state = $request->getQueryParams()['state'] ?? null;
        $code = $request->getQueryParams()['code'] ?? null;
        if(empty($state) || $state !== $_SESSION['oauth2state']){
            $response->getBody()->write('Authorization state mismatch');
            return $response->withStatus(401);
        }
        $token = $provider->getAccessToken('authorization_code', [
            'code' => $code
        ]);
        $user = $provider->getResourceOwner($token)->toArray();
        $picture = $user['picture'];
        $user = [
            "first_name" => $user['given_name'],
            "last_name" => $user['family_name'],   
            "email" => $user['email'],   
        ];
        return $this->createUser($response, $user, $picture);
    }

    private function cleaner(string $dirty){
        $dirty = trim($dirty);
        $dirty = stripslashes($dirty);
        $clean = htmlspecialchars($dirty);
        return $clean;
    }

    private function validateUser(array $user){
        $provinces = ['Balochistan', 'Khyber Pakhtunkhwa', 'Punjab', 'Sindh', 'Islamabad Capital Territory']; 
        $trades = ['Architect', 'Brick Layer', 'Carpenter', 'Electrician', 'Fence Installer', 'HVAC', 'Interior Designer', 'Landscaper', 'Mason', 'Plumber', 'Roofer'];
        $skills = ['No Experience', 'Helper', 'Apprentice (1st Year)', 'Apprentice (2nd Year)', 'Apprentice (3rd Year)', 'Apprentice (4th Year)', 'Journeyman', 'Master'];
        $oneWordRegex = '/^[a-zA-Z\.\-]*$/';
        $mobilenoRegex = '/^\d{10}$/';
        $streetAddressRegex = '/^[\w\s#.\\/,\(\)-]+$/';
        $zipcodeRegex = '/^\d{5}$/';
        if(!preg_match($oneWordRegex, $user['first_name'])) return false;
        else if(!preg_match($oneWordRegex, $user['last_name'])) return false;
        else if(!$this->validateEmail($user['email'])) return false;
        else if(!preg_match($mobilenoRegex, $user['mobileno'])) return false;
        else if(!preg_match($streetAddressRegex, $user['street_address'])) return false;
        else if(!preg_match($oneWordRegex, $user['city'])) return false;
        else if(!in_array($user['province'], $provinces)) return false;
        else if(!preg_match($zipcodeRegex, $user['zipcode'])) return false;
        else if(!in_array($user['trade'], $trades)) return false;
        else if(!in_array($user['skill'], $skills)) return false;
        else if(!in_array($user['work_province'], $provinces)) return false;
        else if(!$this->validatePassword($user['password'])) return false;
        else return true;
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
    private function validateImage($profile_picture){
        $imgSizeMax = 500000;
        $validImageTypes = array('image/jpg', 'image/jpeg', 'image/png');
        if($profile_picture->getSize() > $imgSizeMax) return false;
        if(!in_array($profile_picture->getClientMediaType(),$validImageTypes)) return false; 
        else return true; 
    }
}
