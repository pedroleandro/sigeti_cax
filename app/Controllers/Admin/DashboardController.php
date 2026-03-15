<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Ticket;
use CoffeeCode\Paginator\Paginator;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");
        Auth::requireRole("tecnico");
    }

    public function dashboard(?array $data): void
    {
        $page = $data["page"] ?? 1;

        $limit = 10;

        $ticketModel = new Ticket();

        $total = $ticketModel->count();

        $paginator = new Paginator(
            url("/admin/dashboard/"),
            "Página"
        );

        $paginator->pager($total, $limit, $page);

        $tickets = $ticketModel
            ->orderBy("created_at", "DESC")
            ->limit($paginator->limit())
            ->offset($paginator->offset())
            ->get();

        echo $this->view->render("admin/dashboard", [
            "title" => "Dashboard | " . APP_NAME,
            "tickets" => $tickets,
            "paginator" => $paginator
        ]);
    }
}