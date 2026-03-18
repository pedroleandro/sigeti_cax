<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Session;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");
    }

    public function login()
    {
        if (Auth::check()) {

            if (Auth::role() === "tecnico") {
                redirect("/admin/dashboard");
            }

            if (Auth::role() === "professor") {
                redirect("/professor/dashboard");
            }
        }

        echo $this->view->render('auth/login', [
            "title" => "Entrar | " . APP_NAME
        ]);
    }

    public function authenticate(?array $data): void
    {
        if (!$data || !csrf_verify($data["_csrf"] ?? null)) {
            flash("error", "Token de segurança inválido.");
            redirect("/entrar");
            return;
        }

        if (empty($data["email"]) || empty($data["password"])) {
            flash("error", "Informe email e senha.");
            redirect("/entrar");
            return;
        }

        $user = User::findByEmail($data["email"]);

        if(!$user){
            flash("warning", "E-mail não cadastrado!");
            redirect("/entrar");
        }

        if ($user->getStatus() === "inativo") {
            flash("warning", "Usuário inativo! Contate o administrador.");
            redirect("/entrar");
            return;
        }

        if (!$user || !$user->verifyPassword($data["password"])) {
            flash("error", "Email ou senha inválidos.");
            redirect("/entrar");
            return;
        }

        $session = new Session();

        $session->set("auth", [
            "id" => $user->getId(),
            "name" => $user->getName(),
            "email" => $user->getEmail(),
            "role" => $user->getRole()
        ]);

        $session->regenerate();

        if ($user->getRole() === "tecnico") {
            flash("success", "Bem-vindo, {$user->getName()}!");
            redirect("/admin/dashboard");
            return;
        }

        if ($user->getRole() === "professor") {
            flash("success", "Bem-vindo, Professor(a) {$user->getName()}!");
            redirect("/professor/dashboard");
            return;
        }

        redirect("/entrar");
        return;
    }

    public function logout(?array $data): void
    {
        $session = new Session();
        $auth = $session->auth;

        if (!$data || !csrf_verify($data["_csrf"] ?? null)) {

            flash("error", "Token de segurança inválido.");

            if ($auth) {

                if ($auth->role === "tecnico") {
                    redirect("/admin/dashboard");
                    return;
                }

                if ($auth->role === "professor") {
                    redirect("/professor/dashboard");
                    return;
                }
            }

            redirect("/entrar");
            return;
        }

        $session->unset("auth");
        $session->regenerate();

        flash("success", "Sessão encerrada, mas volte logo!");

        redirect("/entrar");
        return;
    }

    public function register()
    {
        echo $this->view->render('auth/register', [
            "title" => "Registrar | " . APP_NAME
        ]);
    }

    public function store(?array $data): void
    {
        if (!$data || !csrf_verify($data["_csrf"] ?? null)) {
            flash("error", "Token de segurança inválido.");
            redirect("/entrar");
            return;
        }

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
                "status" => "registrado"
            ]);

            $user->save();

        } catch (\InvalidArgumentException $exception) {
            flash("error", $exception->getMessage());
            redirect("/registrar");
            return;
        }

        flash("success", "Conta criada com sucesso.");
        redirect("/entrar");
        return;
    }

    public function forgotPassword()
    {
        echo $this->view->render('auth/forgot-password', [
            "title" => "Esqueci a senha | " . APP_NAME
        ]);
    }
}