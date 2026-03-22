<?php

namespace App\Controllers;

use App\Core\Controller;

class ErrorController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index(?array $data): void
    {
        switch ($data['errcode']) {
            case 404:
                $errorCode = 404;
                $errorTitle = "Página Não Encontrada";
                $errorMessage = "";
                break;
            case 405:
                $errorCode = 405;
                $errorTitle = "Página Não Implementada";
                $errorMessage = "";
                break;
            default:
                $errorCode = 500;
                $errorTitle = "Erro Interno do Servidor";
                $errorMessage = "";
                break;
        }

        echo $this->view->render("error/404", [
            "errorCode" => $errorCode,
            "errorTitle" => $errorTitle,
            "errorMessage" => $errorMessage,
        ]);
    }

}