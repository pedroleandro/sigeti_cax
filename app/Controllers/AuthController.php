<?php

namespace App\Controllers;

use App\Core\Controller;

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");
    }

    public function login()
    {
        echo $this->view->render('auth/login', [
            "title" => "Entrar | " . APP_NAME
        ]);
    }

    public function register()
    {
        echo $this->view->render('auth/register', [
            "title" => "Registrar | " . APP_NAME
        ]);
    }

    public function forgotPassword()
    {
        echo $this->view->render('auth/forgot-password', [
            "title" => "Esqueci a senha | " . APP_NAME
        ]);
    }
}