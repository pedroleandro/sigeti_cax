<?php

namespace App\Controllers\Teacher;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Session;
use App\Models\Ticket;
use App\Models\User;
use CoffeeCode\Paginator\Paginator;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");

        Auth::requireRole(User::TEACHER);
    }

    public function dashboard(?array $data): void
    {
        $page = $data["page"] ?? 1;

        $limit = 10;

        $statusCounts = (new Ticket())
            ->where('opened_by', '=', Auth::user()->id)
            ->countGroupBy('status');

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

        $total = $ticketModel
            ->where('opened_by', '=', Auth::user()->id)
            ->count();

        $paginator = new Paginator(
            url("/professor/dashboard/"),
            "Página"
        );

        $paginator->pager($total, $limit, $page);

        $tickets = (new Ticket())->allOrderedByUser(
            Auth::user()->id,
            $paginator->limit(),
            $paginator->offset()
        );

        echo $this->view->render("teacher/dashboard", [
            "title" => "Dashboard | " . APP_NAME,
            "counts" => $counts,
            "tickets" => $tickets,
            "paginator" => $paginator,
        ]);
    }
}