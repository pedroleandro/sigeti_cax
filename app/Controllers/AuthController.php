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

            if (Auth::role() === User::TECHNICIAN) {
                redirect("/admin/dashboard");
                return;
            }

            if (Auth::role() === User::TEACHER) {
                redirect("/professor/dashboard");
                return;
            }

        }

        echo $this->view->render('auth/login', [
            "title" => "Entrar | " . APP_NAME
        ]);
    }

    public function authenticate(?array $data): void
    {
        $this->validateCsrfToken($data, "/entrar");

        if (empty($data['email']) || empty($data['password'])) {
            flash("warning", "Os campos EMAIL e SENHA são obrigatorios.");
            redirect("/entrar");
            return;
        }

        $user = User::findByEmail($data['email']);

        if (!$user || !$user->passwordVerify($data['password'])) {
            flash("warning","Credenciais inválidas.");
            redirect("/entrar");
            return;
        }

        if ($user->getStatus() === User::INACTIVE) {
            flash("error","Usuário está INATIVO. Contate o administrador.");
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

        $user->setLastLoginAt();
        $user->save();

        if ($user->getRole() === User::TECHNICIAN) {
            flash("success","Bem-vindo(a), " . $user->getName());
            redirect("/admin/dashboard");
            return;
        }

        if ($user->getRole() === User::TEACHER) {
            flash("success","Bem-vindo(a), Professor(a) " . $user->getName());
            redirect("/professor/dashboard");
            return;
        }

        $session->destroy();
        flash("error","Perfil de acesso não reconhecido.");
        redirect("/entrar");
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
        $this->validateCsrfToken($data, "/registrar");

        $required = [
            "name" => "O campo NOME é obrigatorio.",
            "email" => "O campo EMAIL é obrigatorio.",
            "password" => "O campo SENHA é obrigatorio.",
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
                "role" => User::TEACHER,
                "status" => User::REGISTERED
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