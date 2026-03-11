<?php

namespace App\Controllers\Admin;

use App\Core\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");
    }

    public function dashboard(): void
    {
        echo $this->view->render("admin/dashboard", [
            "title" => "Dashboard | " . APP_NAME
        ]);
    }
}