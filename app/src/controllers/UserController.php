<?php

namespace app\controllers;


use app\core\Session;
use app\models\User;

class UserController extends Controller
{
    public function login()
    {
        if (isset($_POST['login_btn']))
        {
            $this->verifyInputs($_POST['username'], $_POST['password']);

            if(count($this->errors) == 0)
            {
                $username = $this->escape($_POST['username']);
                $password = $this->escape($_POST['password']);
                $user = new User();
                $result = $user->login($username, $password);
                if($result)
                {
                    $this->startSession();
                    $this->setSession([
                        'user' => $result['login'],
                        'admin'=> true,
                        'id'   => $result['id']
                    ]);
                    header('location:' . $this->generateRoute("adminHome"));
                    exit();
                }
                else
                {
                    array_push($this->errors, "Wrong Username/Password");
                }
            }
        }
        $this->render("index",["errors" => $this->errors]);
    }

    function verifyInputs(?string $username, ?string $password)
    {

        if (empty($username) || !$this->isString($username))
        {
            return(array_push($this->errors, "Le login est manquant , veuillez réessayer"));
        }
        if (empty($password) || !$this->isString($password))
        {
            return(array_push($this->errors, "Le mot de passe est manquant , veuillez réessayer"));
        }
        return null;
    }

    function logOut() {
        $this->isAdminLogged();
        $_SESSION = [];
        session_destroy();
        header('location:' . $this->generateRoute("home"));
    }
}