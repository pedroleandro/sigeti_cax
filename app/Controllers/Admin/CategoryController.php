<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Category;
use App\Models\User;
use CoffeeCode\Paginator\Paginator;

class CategoryController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");

        Auth::requireRole(User::TECHNICIAN);
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
        $this->validateCsrfToken($data, "/admin/categorias/cadastrar");

        $newCategory = new Category();

        $errors = $newCategory->validate($data);

        if ($errors) {
            flash("error", implode("<br>", $errors));
            redirect("/admin/categorias/cadastrar");
            return;
        }

        if ($newCategory->findByName($data["name"])) {
            flash("warning", "Já existe uma categoria com esse mesmo nome.");
            redirect("/admin/categorias/cadastrar");
            return;
        }

        try {

            $newCategory->fill([
                "name" => $data["name"],
                "description" => $data["description"]
            ]);

            $newCategory->save();

        } catch (\InvalidArgumentException $invalidArgumentException) {

            flash("error", $invalidArgumentException->getMessage());
            redirect("/admin/categorias/cadastrar");
            return;

        }

        flash("success", "Categoria cadastrada com sucesso.");
        redirect("/admin/categorias/editar/" . $newCategory->getId());
    }

    public function edit(?array $data): void
    {
        $category = Category::find($data['id']);

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
        $this->validateCsrfToken($data, "/admin/categorias/editar/" . $data["id"]);

        $category = Category::find((int)$data['id']);

        if (!$category) {
            flash('warning', 'Categoria não encontrada.');
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
                "description" => $data["description"] ?? null
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