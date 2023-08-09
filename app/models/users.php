<?php 
namespace App\Models;
class Users extends \Model {
    public static $_id = 'id';
    public static $_table = 'users';
    public function createUser($email, $password){
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
}