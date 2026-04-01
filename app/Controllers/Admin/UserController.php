<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\School;
use App\Models\SchoolUser;
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
        $this->validateCsrfToken($data, "/admin/usuarios/cadastrar");

        $user = new User();
        $errors = $user->validate($data);

        if ($errors) {
            flash("error", implode("<br>", $errors));
            redirect("/admin/usuarios/cadastrar");
            return;
        }

        if (User::findByEmail($data["email"])) {
            flash("warning", "Este email já está cadastrado.");
            redirect("/admin/usuarios/cadastrar");
            return;
        }

        $role = $data["role"] ?? User::TEACHER;

        if ($role === User::TEACHER) {

            $linkErrors = SchoolUser::validateLinks($data["schools"] ?? []);

            if ($linkErrors) {
                flash("error", implode("<br>", $linkErrors));
                redirect("/admin/usuarios/cadastrar");
                return;
            }
        }

        try {

            $user->fill([
                "name" => $data["name"],
                "email" => $data["email"],
                "password" => $data["password"],
                "document" => $data["document"] ?? null,
                "role" => $role,
                "status" => $data["status"] ?? "registrado"
            ]);

            $user->save();

            if ($user->getRole() === "professor") {
                $this->syncSchoolLinks($user->getId(), $data["schools"] ?? []);
            }

        } catch (\InvalidArgumentException $e) {

            flash("error", $e->getMessage());
            redirect("/admin/usuarios/cadastrar");
            return;

        }

        flash("success", "Usuário cadastrado com sucesso.");
        redirect("/admin/usuarios/editar/" . $user->getId());
    }

    public function edit(?array $data): void
    {
        $user = User::find($data['id']);

        if (!$user) {
            flash("error", "Usuário não encontrado.");
            redirect("/admin/usuarios");
            return;
        }

        $schools = School::all();
        $userSchools = $user->schools();

        echo $this->view->render("/admin/user/edit", [
            "title" => "Editar Usuário | " . APP_NAME,
            "user" => $user,
            "schools" => $schools,
            "userSchools" => $userSchools
        ]);
    }

    public function update(?array $data): void
    {
        $this->validateCsrfToken($data, "/admin/usuarios");

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

        $existing = User::findByEmail($data["email"]);

        if ($existing && $existing->getId() !== $user->getId()) {
            flash("warning", "Este email já está cadastrado.");
            redirect("/admin/usuarios/editar/" . $user->getId());
            return;
        }

        $role = $data["role"] ?? $user->getRole();

        if ($role === User::TEACHER) {

            $linkErrors = SchoolUser::validateLinks($data["schools"] ?? []);

            if ($linkErrors) {
                flash("error", implode("<br>", $linkErrors));
                redirect("/admin/usuarios/editar/" . $user->getId());
                return;
            }
        }

        try {

            $user->fill([
                "name" => $data["name"],
                "email" => $data["email"],
                "password" => $data["password"] ?? null,
                "document" => $data["document"] ?? null,
                "role" => $role,
                "status" => $data["status"]
            ]);

            $user->save();

            $this->removeAllSchoolLinks($user->getId());

            if ($role === User::TEACHER) {
                $this->syncSchoolLinks($user->getId(), $data["schools"] ?? []);
            } else {
                $this->removeAllSchoolLinks($user->getId());
            }

        } catch (\InvalidArgumentException $e) {

            flash("error", $e->getMessage());
            redirect("/admin/usuarios/editar/" . $user->getId());
            return;

        }

        flash("success", "Usuário atualizado com sucesso.");
        redirect("/admin/usuarios/editar/" . $user->getId());
    }

    private function syncSchoolLinks(int $userId, array $schools): void
    {
        $this->removeAllSchoolLinks($userId);

        foreach ($schools as $entry) {
            $schoolId = (int)($entry["school_id"] ?? 0);
            $shift = $entry["shift"] ?? "integral";

            if (!$schoolId) {
                continue;
            }

            $link = new SchoolUser();
            $link->fill([
                "school_id" => $schoolId,
                "user_id" => $userId,
                "shift" => $shift
            ]);
            $link->save();
        }
    }

    private function removeAllSchoolLinks(int $userId): void
    {
        $links = (new SchoolUser())
            ->where("user_id", "=", $userId)
            ->get();

        /** @var SchoolUser $link */
        foreach ($links as $link) {
            $link->delete();
        }
    }
}