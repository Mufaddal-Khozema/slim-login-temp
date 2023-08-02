<?php
require_once __DIR__ . '/users.php';
class UserModel {
    public function createUser(string $email, string $password) 
    {
        try {
            $data = Model::factory('Users')->where("email", $email)->findMany();
            if (!empty($data)){
                throw new Exception("Account Already Exists");
            }else {
                $user = Model::factory('Users')->create();
                $user->createUser($email, $password);
                $user->save();
            }
            return json_encode("Success");
        } catch (PDOException $e) {
            return $e->getMessage();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        
        // return $res;
        // return json_encode($data);
        // global $conn;
        // try {
        //     $sql = "SELECT * FROM users WHERE email='$email'";
        //     $results = $conn->query($sql);
        //     $row = $results->fetch(PDO::FETCH_ASSOC);
        //     if(is_array($row) && count($row)>0){
        //         return "Account of this email already exists";
        //     }else {
        //         $stmt = $conn->prepare("INSERT INTO users (email, password) VALUE(?,?)");
        //         $res = $stmt->execute([$email,password_hash($password,PASSWORD_DEFAULT)]);
        //         if(!$res){
        //             return "failed to make database entry";
        //         }
        //     }

        // } catch (PDOException $e) {
        //     throw new Exception($e->getMessage());
        // }
    }
}