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

        $limit = 3;

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
        var_dump($data);
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
        if (!$data || empty($data['id'])) {
            redirect('/admin/usarios');
            return;
        }

        $user = User::find((int)$data['id']);

        if (!$user) {
            flash('error', 'Usuário não encontrado.');
            redirect('/admin/usuarios');
            return;
        }

        try {

            $user->fill($data);

            if (!$user->save()) {
                flash('error', 'Erro ao atualizar o usuário.');
                redirect('/admin/usuarios/editar/' . $data['id']);
                return;
            }

            flash('success', 'Usuário atualizado com sucesso.');
            redirect('/admin/usuarios');

        } catch (\InvalidArgumentException $exception) {
            flash('error', $exception->getMessage());
            redirect('/admin/escolas/editar/' . $data['id']);
        }
    }
}