<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Category;
use App\Models\School;
use CoffeeCode\Paginator\Paginator;

class CategoryController extends Controller
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

        $categoryModel = new Category();

        $total = $categoryModel->count();

        $paginator = new Paginator(
            url("/admin/categorias/"),
            "Página"
        );

        $paginator->pager($total, $limit, $page);

        $categories = $categoryModel
            ->orderBy("name")
            ->limit($paginator->limit())
            ->offset($paginator->offset())
            ->get();

        echo $this->view->render('/admin/category/index', [
            "title" => "Categorias Cadastradas | " . APP_NAME,
            "categories" => $categories,
            "paginator" => $paginator
        ]);
    }

    public function create(?array $data): void
    {
        echo $this->view->render('/admin/category/create', [
            "title" => "Cadastrar Nova Categoria | " . APP_NAME
        ]);
    }

    public function store(?array $data): void
    {
        if (!$data || !csrf_verify($data["_csrf"] ?? null)) {
            flash("error", "Token de segurança inválido.");
            redirect("/admin/categorias/cadastrar");
            return;
        }

        $category = new Category();

        $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);
        $errors = $category->validate($data);

        if ($errors) {
            flash("error", implode("<br>", $errors));
            redirect("/admin/categorias/cadastrar");
            return;
        }

        try {

            $category->fill([
                "name" => $data["name"],
                "description" => $data["description"]
            ]);

            $category->save();

        } catch (\InvalidArgumentException $exception) {

            flash("error", $exception->getMessage());
            redirect("/admin/categorias/cadastrar");
            return;
        }

        flash("success", "Categoria cadastrada com sucesso.");
        redirect("/admin/categorias/editar/" . $category->getId());
        return;
    }

    public function edit(?array $data): void
    {
        $id = $data['id'] ?? null;

        if (!$id) {
            redirect('/admin/categorias');
            return;
        }

        $category = Category::find($id);

        if (!$category) {
            flash('error', 'Categoria não encontrada');
            redirect('/admin/categorias');
            return;
        }

        echo $this->view->render('/admin/category/edit', [
            'title' => 'Editar Categoria | ' . APP_NAME,
            'category' => $category
        ]);
    }

    public function update(?array $data): void
    {
        if (!$data || !csrf_verify($data["_csrf"] ?? null)) {
            flash("error", "Token de segurança inválido.");
            redirect("/admin/categorias");
        }

        if (empty($data["id"])) {
            flash("error", "Categoria inválida.");
            redirect("/admin/categorias");
            return;
        }

        $category = Category::find((int)$data['id']);

        if (!$category) {
            flash('error', 'Categoria não encontrada.');
            redirect('/admin/categorias');
            return;
        }

        $errors = $category->validate($data);

        if ($errors) {
            flash("error", implode("<br>", $errors));
            redirect("/admin/categorias/editar/" . $category->getId());
            return;
        }

        try {

            $category->fill([
                "name" => $data["name"],
                "description" => $data["description"]
            ]);

            if (!$category->save()) {
                flash('error', 'Erro ao atualizar a categoria.');
                redirect('/admin/categorias/editar/' . $data['id']);
                return;
            }

            flash('success', 'Categoria atualizada com sucesso.');
            redirect('/admin/categorias/editar/' . $data['id']);
            return;

        } catch (\InvalidArgumentException $exception) {
            flash('error', $exception->getMessage());
            redirect('/admin/categorias/editar/' . $data['id']);
        }
    }


}