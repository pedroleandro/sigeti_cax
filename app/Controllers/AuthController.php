<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

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

    public function authenticate(?array $data): void
    {
        var_dump($data);
    }

    public function store(?array $data): void
    {
        $required = [
            "name" => "O nome é obrigatório.",
            "email" => "O email é obrigatório.",
            "password" => "A senha é obrigatória."
        ];

        $errors = [];

        foreach ($required as $field => $message) {
            if (empty($data[$field])) {
                $errors[] = $message;
            }
        }

        if ($errors) {
            flash("error", implode("<br>", $errors));
            redirect("/registrar");
        }

        $userExists = User::findByEmail($data["email"]);

        if ($userExists) {
            flash("warning", "Este email já está cadastrado.");
            redirect("/registrar");
        }

        $user = new User();

        try {
            $user->fill([
                "name" => $data["name"],
                "email" => $data["email"],
                "password" => $data["password"],
                "role" => "professor",
                "status" => "ativo"
            ]);

            $user->save();

        } catch (\InvalidArgumentException $exception) {
            flash("error", $exception->getMessage());
            redirect("/registrar");
        }

        flash("success", "Conta criada com sucesso.");
        redirect("/entrar");
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