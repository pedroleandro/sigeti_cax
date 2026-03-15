<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\School;
use CoffeeCode\Paginator\Paginator;

class SchoolController extends Controller
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

        $schoolModel = new School();

        $total = $schoolModel->count();

        $paginator = new Paginator(
            url("/admin/escolas/"),
            "Página"
        );

        $paginator->pager($total, $limit, $page);

        $schools = $schoolModel
            ->orderBy("name")
            ->limit($paginator->limit())
            ->offset($paginator->offset())
            ->get();

        echo $this->view->render('/admin/school/index', [
            "title" => "Escolas Cadastradas | " . APP_NAME,
            "schools" => $schools,
            "paginator" => $paginator
        ]);
    }

    public function create(): void
    {
        echo $this->view->render('/admin/school/create', [
            "title" => "Cadastrar Nova Escola | " . APP_NAME
        ]);
    }

    public function store(?array $data): void
    {
        if (!$data || !csrf_verify($data["_csrf"] ?? null)) {
            flash("error", "Token de segurança inválido.");
            redirect("/admin/escolas/cadastrar");
            return;
        }

        $school = new School();

        $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);
        $errors = $school->validate($data);

        if ($errors) {
            flash("error", implode("<br>", $errors));
            redirect("/admin/escolas/cadastrar");
            return;
        }

        try {

            $school->fill([
                "name" => $data["name"],
                "code" => $data["code"],
                "address" => $data["address"]
            ]);

            $school->save();

        } catch (\InvalidArgumentException $exception) {

            flash("error", $exception->getMessage());
            redirect("/admin/escolas/cadastrar");
            return;
        }

        flash("success", "Escola cadastrada com sucesso.");
        redirect("/admin/escolas/editar/" . $school->getId());
        return;
    }

    public function edit(?array $data): void
    {
        $id = $data['id'] ?? null;

        if (!$id) {
            redirect('/admin/escolas');
            return;
        }

        $school = School::find($id);

        if (!$school) {
            flash('error', 'Escola não encontrada');
            redirect('/admin/escolas');
            return;
        }

        echo $this->view->render('/admin/school/edit', [
            'title' => 'Editar Escola | ' . APP_NAME,
            'school' => $school
        ]);
    }

    public function update(?array $data): void
    {
        if (!$data || !csrf_verify($data["_csrf"] ?? null)) {
            flash("error", "Token de segurança inválido.");
            redirect("/admin/escolas");
            return;
        }

        if (empty($data["id"])) {
            flash("error", "Escola inválida.");
            redirect("/admin/escolas");
            return;
        }

        $school = School::find($data["id"]);

        if (!$school) {
            flash("error", "Escola não encontrada.");
            redirect("/admin/escolas");
            return;
        }

        $errors = $school->validate($data);

        if ($errors) {
            flash("error", implode("<br>", $errors));
            redirect("/admin/escolas/editar/" . $school->getId());
            return;
        }

        try {

            $school->fill([
                "name" => $data["name"],
                "code" => $data["code"],
                "address" => $data["address"]
            ]);

            $school->save();

        } catch (\InvalidArgumentException $exception) {

            flash("error", $exception->getMessage());
            redirect("/admin/escolas/editar/" . $data["id"]);
            return;
        }

        flash("success", "Escola atualizada com sucesso.");
        redirect("/admin/escolas/editar/" . $school->getId());
        return;
    }
}