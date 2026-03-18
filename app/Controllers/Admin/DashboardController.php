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

        $statusCounts = (new Ticket())->countGroupBy('status');

        $counts = [
            'aberto' => 0,
            'em_andamento' => 0,
            'aguardando' => 0,
            'resolvido' => 0,
            'finalizado' => 0,
            'arquivado' => 0,
        ];

        foreach ($statusCounts as $row) {
            if (isset($counts[$row['status']])) {
                $counts[$row['status']] = (int)$row['total'];
            }
        }

        $ticketModel = new Ticket();
        $total = $ticketModel
            ->whereIn('status', ['aberto', 'em_andamento', 'aguardando'])
            ->count();

        $paginator = new Paginator(url("/admin/dashboard/"), "Página");
        $paginator->pager($total, $limit, $page);

        $tickets = (new Ticket())
            ->whereIn('status', ['aberto', 'em_andamento', 'aguardando'])
            ->orderBy('priority', 'DESC')
            ->orderBy('opened_at', 'ASC')
            ->limit($paginator->limit())
            ->offset($paginator->offset())
            ->get();

        echo $this->view->render("admin/dashboard", [
            "title" => "Dashboard | " . APP_NAME,
            "counts" => $counts,
            "tickets" => $tickets,
            "paginator" => $paginator
        ]);
    }
}