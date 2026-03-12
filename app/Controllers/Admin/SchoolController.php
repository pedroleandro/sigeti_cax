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

        $limit = 3;

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
        var_dump($data);
    }
}