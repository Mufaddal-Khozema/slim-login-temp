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
    }

    // $errors = array();
    // try
    // {
    //     $email = checkEmail($_POST['email']);
    // } catch (Exception $e) 
    // {
    //     $errors['emailErr'] = $e->getMessage();
    // }

    // try
    // {
    //     $password = checkPassword($_POST['password']);
    // } catch (Exception $e)
    // {
    //     $errors['passwordErr'] = $e->getMEssage();
    // }

    // try {

    //     UserController::loginUser($email, $password);

    // } catch(Exception $e){
    //     $errors["databaseErr"] = $e->getMessage();
    // }
    // if(empty($errors)) {
    //     echo json_encode(array("success" => "true"));
    // } else {
    //     echo json_encode($errors); 
    // }
}