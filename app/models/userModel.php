<?php 
namespace App\Models;
class UserModel {
    public function createUser(string $email, string $password) 
    {
        \Model::$short_table_names = true;
        $data = \Model::factory('App\Models\Users')->where("email", $email)->findMany();
        if (!empty($data)){
            throw new \Exception("Account Already Exists");
        }else {
            $user = \Model::factory('App\Models\Users')->create();
            $user->createUser($email, $password);
            $user->save();
        }
    }

    public function loginUser(string $email, string $password)
    {
        $data = \Model::factory('App\Models\Users')->where('email', $email)->findOne();
        if (empty($data)){
            throw new \Exception("Account Does not Exist");
        }else {
            if(!password_verify($password, $data->password)){
                throw new \Exception("Incorrect Password");
            }
        }
    }
}