<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Session;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use CoffeeCode\Paginator\Paginator;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");

        Auth::requireRole(User::TECHNICIAN);
    }

    public function dashboard(?array $data): void
    {
        $page = $data["page"] ?? 1;

        $limit = 10;

        $statusCounts = (new Ticket())->countGroupBy('status');

        $counts = [
            Ticket::OPEN => 0,
            Ticket::IN_PROGRESS => 0,
            Ticket::WAITING => 0,
            Ticket::RESOLVED => 0,
            Ticket::FINISHED => 0,
            Ticket::ARCHIVED => 0,
        ];

        foreach ($statusCounts as $row) {
            if (isset($counts[$row['status']])) {
                $counts[$row['status']] = (int)$row['total'];
            }
        }

        $ticketModel = new Ticket();

        $total = $ticketModel->count();

        $paginator = new Paginator(
            url("/admin/dashboard/"),
            "Página"
        );

        $paginator->pager($total, $limit, $page);

        $tickets = (new Ticket())->allOrdered(
            $paginator->limit(),
            $paginator->offset()
        );

        $year = 2024;
        $months = array_fill(1, 12, 0);

        foreach ((new Ticket())->countByMonth($year) as $row) {
            $months[(int)$row['month']] = (int)$row['total'];
        }

        $monthlyData = array_values($months);

        $categories = Category::all();

        $categoryData = (new Ticket())->countByCategory($year);
        $categoryNames = array_column($categoryData, 'category');
        $categoryTotals = array_column($categoryData, 'total');

        echo $this->view->render("admin/dashboard", [
            "title" => "Dashboard | " . APP_NAME,
            "counts" => $counts,
            "tickets" => $tickets,
            "paginator" => $paginator,
            "year" => $year,
            "monthlyData" => $monthlyData,
            "categories" => $categories,
            "categoryNames" => $categoryNames,
            "categoryTotals" => $categoryTotals,
        ]);
    }
}