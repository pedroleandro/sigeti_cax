<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\School;

class SchoolController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");

        Auth::requireRole("tecnico");
    }

    public function index()
    {
        /** @var School $schools */
        $schools = School::all();

        echo $this->view->render('/admin/school/index', [
            "title" => "Escolas Cadastradas | " . APP_NAME,
            "schools" => $schools
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