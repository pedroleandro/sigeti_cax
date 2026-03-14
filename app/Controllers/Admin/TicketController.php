<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Ticket;
use CoffeeCode\Paginator\Paginator;

class TicketController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");

        Auth::requireRole("tecnico");
    }

    public function index(?array $data): void
    {
        $page = $data["page"] ?? 1;

        $limit = 7;

        $ticketModel = new Ticket();

        $total = $ticketModel->count();

        $paginator = new Paginator(
            url("/admin/chamados/"),
            "Página"
        );

        $paginator->pager($total, $limit, $page);

        $tickets = $ticketModel
            ->orderBy("created_at", "DESC")
            ->limit($paginator->limit())
            ->offset($paginator->offset())
            ->get();

        echo $this->view->render('/admin/ticket/index', [
            "title" => "Chamados Cadastrados | " . APP_NAME,
            "tickets" => $tickets,
            "paginator" => $paginator
        ]);
    }

    public function create(?array $data): void
    {
        echo $this->view->render('/admin/ticket/create', [
            "title" => "Cadastrar Novo Chamado | " . APP_NAME
        ]);
    }

    public function store(?array $data): void
    {
        var_dump($data);
    }

    public function edit(?array $data): void
    {
        $id = $data['id'] ?? null;

        if (!$id) {
            redirect('/admin/chamados');
            return;
        }

        $ticket = Ticket::find($id);

        if (!$ticket) {
            flash('error', 'Ticket não encontrada');
            redirect('/admin/chamados');
            return;
        }

        echo $this->view->render('/admin/ticket/edit', [
            'title' => 'Editar Chamado | ' . APP_NAME,
            'ticket' => $ticket
        ]);
    }
}