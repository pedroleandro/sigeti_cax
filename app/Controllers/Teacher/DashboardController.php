<?php

namespace App\Controllers\Teacher;

use App\Core\Auth;
use App\Core\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");
        Auth::requireRole("professor");
    }

    public function dashboard(): void
    {
        echo $this->view->render("teacher/dashboard", [
            "title" => "Dashboard | " . APP_NAME
        ]);
    }
}