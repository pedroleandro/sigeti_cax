<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");
        Auth::requireRole("tecnico");
    }

    public function dashboard(): void
    {
        echo $this->view->render("admin/dashboard", [
            "title" => "Dashboard | " . APP_NAME
        ]);
    }
}