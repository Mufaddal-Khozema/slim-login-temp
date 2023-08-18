<?php 
namespace App\Models;

use GuzzleHttp\Psr7\UploadedFile;
use Slim\Psr7\UploadedFile as Psr7UploadedFile;

\Model::$short_table_names = true;

class UserModel {
    public function createUser(array $user, UploadedFile|string $image) 
    {
        $data = \Model::factory('App\Models\Users')->where("email", $user['email'])->findMany();
        if (!empty($data)){
            throw new \RuntimeException("Account Already Exists");
        }else {
            $newUser = \Model::factory('App\Models\Users')->create();
            $newUser->createUser($user, $image);
            $newUser->save();
            return md5($newUser->id);
        }
    }

    public function loginUser(string $email, string $password)
    {
        $user = \Model::factory('App\Models\Users')->where('email', $email)->findOne();
        if (empty($user)){
            throw new \Exception("Account Does not Exist");
        }
        if(!password_verify($password, $user->password)){
            throw new \Exception("Incorrect Password");
        }
        return md5($user->id);
    }
}