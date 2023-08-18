<?php 
namespace App\Models;

use Slim\Psr7\UploadedFile;

class Users extends \Model {
    public static $_id = 'id';
    public static $_table = 'users';
    public function createUser(array $user, UploadedFile|string $profile_picture){
        $this->first_name = $user['first_name'] ?? null;
        $this->last_name = $user['last_name'] ?? null;
        $this->email = $user['email'] ?? null;
        $this->mobile_number = $user['mobileno'] ?? null;
        $this->street_address = $user['street_address'] ?? null;
        $this->city = $user['city'] ?? null;
        $this->province = $user['province'] ?? null;
        $this->zipcode = $user['zipcode'] ?? null;
        $this->trade = $user['trade'] ?? null;
        $this->skill = $user['skill'] ?? null;
        $this->work_province = $user['work_province'] ?? null;
        $this->password = isset($user['password']) ? password_hash($user['password'], PASSWORD_DEFAULT) : null;
        $this->picture = $profile_picture ?? null;
    }
}