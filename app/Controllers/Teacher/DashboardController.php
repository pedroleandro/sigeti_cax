<?php

namespace App\Controllers\Teacher;

use App\Core\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");
    }

    public function dashboard(): void
    {
        echo $this->view->render("teacher/dashboard", [
            "title" => "Dashboard | " . APP_NAME
        ]);
    }
}