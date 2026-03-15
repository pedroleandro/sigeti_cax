<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\School;
use App\Models\User;
use CoffeeCode\Paginator\Paginator;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");

        Auth::requireRole("tecnico");
    }

    public function index(?array $data): void
    {
        $page = $data["page"] ?? 1;

        $limit = 10;

        $userModel = new User();

        $total = $userModel->count();

        $paginator = new Paginator(
            url("/admin/usuarios/"),
            "Página"
        );

        $paginator->pager($total, $limit, $page);

        $users = $userModel
            ->orderBy("name")
            ->limit($paginator->limit())
            ->offset($paginator->offset())
            ->get();

        echo $this->view->render('/admin/user/index', [
            "title" => "Usuários Cadastrados | " . APP_NAME,
            "users" => $users,
            "paginator" => $paginator
        ]);
    }

    public function create(?array $data): void
    {
        $schools = School::all();

        echo $this->view->render('/admin/user/create', [
            "title" => "Cadastrar Novo Usuário | " . APP_NAME,
            "schools" => $schools
        ]);
    }

    public function store(?array $data): void
    {
        if (!$data || !csrf_verify($data["_csrf"] ?? null)) {
            flash("error", "Token de segurança inválido.");
            redirect("/admin/usuarios/cadastrar");
            return;
        }

        $user = new User();

        $errors = $user->validate($data);

        if ($errors) {
            flash("error", implode("<br>", $errors));
            redirect("/admin/usuarios/cadastrar");
            return;
        }

        $userExists = User::findByEmail($data["email"]);

        if ($userExists) {
            flash("warning", "Este email já está cadastrado.");
            redirect("/admin/usuarios/cadastrar");
            return;
        }

        try {

            $user->fill([
                "school_id" => $data["school_id"] ?? null,
                "name" => $data["name"],
                "email" => $data["email"],
                "password" => $data["password"],
                "document" => $data["document"] ?? null,
                "role" => $data["role"] ?? "professor",
                "status" => $data["status"] ?? "registrado"
            ]);

            $user->save();

        } catch (\InvalidArgumentException $exception) {

            flash("error", $exception->getMessage());
            redirect("/admin/usuarios/cadastrar");
            return;
        }

        flash("success", "Usuário cadastrado com sucesso.");
        redirect("/admin/usuarios/editar/" . $user->getId());
        return;
    }

    public function edit(?array $data): void
    {
        $id = $data['id'] ?? null;

        if (!$id) {
            redirect('/admin/usuarios');
            return;
        }

        $user = User::find($id);

        if (!$user) {
            flash('error', 'Usuário não encontrado');
            redirect('/admin/usuarios');
            return;
        }

        $schools = School::all();

        echo $this->view->render('/admin/user/edit', [
            'title' => 'Editar Usuário | ' . APP_NAME,
            'user' => $user,
            'schools' => $schools
        ]);
    }

    public function update(?array $data): void
    {
        if (!$data || !csrf_verify($data["_csrf"] ?? null)) {
            flash("error", "Token de segurança inválido.");
            redirect("/admin/usuarios");
            return;
        }

        if (empty($data["id"])) {
            flash("error", "Usuário inválido.");
            redirect("/admin/usuarios");
            return;
        }

        $user = User::find($data["id"]);

        if (!$user) {
            flash("error", "Usuário não encontrado.");
            redirect("/admin/usuarios");
            return;
        }

        $errors = $user->validate($data);

        if ($errors) {
            flash("error", implode("<br>", $errors));
            redirect("/admin/usuarios/editar/" . $user->getId());
            return;
        }

        if(empty($data["school_id"])){
            flash("error", "A escola é obrigatória");
            redirect("/admin/usuarios/editar/" . $user->getId());
            return;
        }

        $userExists = User::findByEmail($data["email"]);

        if ($userExists && $userExists->getId() !== $user->getId()) {
            flash("warning", "Este email já está cadastrado.");
            redirect("/admin/usuarios/editar/" . $user->getId());
            return;
        }

        try {

            $user->fill([
                "school_id" => $data["school_id"] ?? null,
                "name" => $data["name"],
                "email" => $data["email"],
                "password" => $data["password"] ?? null,
                "document" => $data["document"] ?? null,
                "role" => $data["role"],
                "status" => $data["status"]
            ]);

            $user->save();

        } catch (\InvalidArgumentException $exception) {

            flash("error", $exception->getMessage());
            redirect("/admin/usuarios/editar/" . $data["id"]);
            return;
        }

        flash("success", "Usuário atualizado com sucesso.");
        redirect("/admin/usuarios/editar/" . $user->getId());
        return;
    }

    public function delete(?array $data): void
    {
        var_dump($data);
    }

    public function requests(?array $data): void
    {
        
    }

    public function technicians(?array $data): void
    {
        
    }

    public function teachers(?array $data): void
    {

    }
}