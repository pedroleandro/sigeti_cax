<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Session;
use App\Models\Category;
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

        $tickets = (new Ticket())->allOrdered(
            $paginator->limit(),
            $paginator->offset()
        );

        if ((new Session())->has("auth")) {
            $user = (new Session())->auth;
        }

        $year = 2024; //(int)date("Y");
        $months = array_fill(1, 12, 0);

        foreach ((new Ticket())->countByMonth($year) as $row) {
            $months[(int)$row['month']] = (int)$row['total'];
        }

        $monthlyData = array_values($months);

        $categories = Category::all();

        $categoryData   = (new Ticket())->countByCategory();
        $categoryNames  = array_column($categoryData, 'category');
        $categoryTotals = array_column($categoryData, 'total');

        echo $this->view->render("admin/dashboard", [
            "title" => "Dashboard | " . APP_NAME,
            "counts" => $counts,
            "tickets" => $tickets,
            "user" => $user ?? [],
            "paginator" => $paginator,
            "year" => $year,
            "monthlyData" => $monthlyData,
            "categories" => $categories,
            "categoryNames"  => $categoryNames,
            "categoryTotals" => $categoryTotals,
        ]);
    }
}