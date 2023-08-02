<?php 
class Users extends Model {
    public function createUser($email, $password){
        $this->email = $email;
        $this->password = $password;
    }
}