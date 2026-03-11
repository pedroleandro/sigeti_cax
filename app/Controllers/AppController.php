<?php

namespace App\Controllers;

use App\Core\Controller;

class AppController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");
    }

    public function dashboard()
    {
        echo $this->view->render('dashboard', [
            'title' => 'Dashboard | ' . APP_NAME,
        ]);
    }
}