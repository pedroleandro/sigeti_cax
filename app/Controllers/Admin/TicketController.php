<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Category;
use App\Models\School;
use App\Models\Ticket;
use App\Models\User;
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
        $limit = 10;

        $ticketModel = new Ticket();
        $total = $ticketModel->count();

        $paginator = new Paginator(url("/admin/chamados/"), "Página");
        $paginator->pager($total, $limit, $page);

        $tickets = $ticketModel->allOrdered(
            $paginator->limit(),
            $paginator->offset()
        );

        echo $this->view->render('/admin/ticket/index', [
            "title" => "Chamados | " . APP_NAME,
            "tickets" => $tickets,
            "paginator" => $paginator
        ]);
    }

    public function create(?array $data): void
    {
        $schools = School::all();
        $categories = Category::all();
        $teachers = (new User())->where("role", "!=", "tecnico")->get();

        echo $this->view->render('/admin/ticket/create', [
            "title" => "Cadastrar Novo Chamado | " . APP_NAME,
            "schools" => $schools,
            "categories" => $categories,
            "teachers" => $teachers,
        ]);
    }

    public function store(?array $data): void
    {
        if (!$data || !csrf_verify($data["_csrf"] ?? null)) {
            flash("error", "Token de segurança inválido.");
            redirect("/admin/chamados/cadastrar");
            return;
        }

        $ticket = new Ticket();

        $errors = $ticket->validate($data);

        if ($errors) {
            flash("error", implode("<br>", $errors));
            redirect("/admin/chamados/cadastrar");
            return;
        }

        try {

            $userId = Auth::user()->id;

            $ticket->fill([
                "title" => $data["title"],
                "description" => $data["description"],
                "school_id" => $data["school_id"],
                "category_id" => $data["category_id"],
                "priority" => $data["priority"] ?? "media",
                "opened_by" => $data["opened_by"],
                "assigned_to" => $userId,
                "status" => "aberto"
            ]);

            $ticket->save();

        } catch (\InvalidArgumentException $exception) {

            flash("error", $exception->getMessage());
            redirect("/admin/chamados/cadastrar");
            return;
        }

        flash("success", "Chamado criado com sucesso.");
        redirect("/admin/chamados/editar/" . $ticket->getId());
        return;
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

        $schools = School::all();
        $categories = Category::all();
        $teachers = (new User())->where("role", "!=", "tecnico")->get();
        $technicians = (new User())->where("role", "=", "tecnico")->get();

        echo $this->view->render('/admin/ticket/edit', [
            'title' => 'Editar Chamado | ' . APP_NAME,
            'ticket' => $ticket,
            "schools" => $schools,
            "categories" => $categories,
            "teachers" => $teachers,
            "technicians" => $technicians,
        ]);
    }

    public function update(?array $data): void
    {
        if (!$data || !csrf_verify($data["_csrf"] ?? null)) {
            flash("error", "Token de segurança inválido.");
            redirect("/admin/chamados");
            return;
        }

        if (empty($data["id"])) {
            flash("error", "Chamado inválido.");
            redirect("/admin/chamados");
            return;
        }

        $ticket = Ticket::find($data["id"]);

        if (!$ticket) {
            flash("error", "Chamado não encontrado.");
            redirect("/admin/chamados");
            return;
        }

        if (empty($data["priority"]) || empty($data["status"])) {
            flash("error", "Prioridade e Status são obrigatórios");
            redirect("/admin/chamados/editar/" . $data["id"]);
            return;
        }

        try {
            $ticket->fill([
                "priority" => $data["priority"],
                "status" => $data["status"],
                "assigned_to" => !empty($data["assigned_to"]) ? (int) $data["assigned_to"] : null
            ]);
            $ticket->save();

        } catch (\InvalidArgumentException $exception) {
            flash("error", $exception->getMessage());
            redirect("/admin/chamados/editar/" . $data["id"]);
            return;
        }

        flash("success", "Chamado atualizado com sucesso.");
        redirect("/admin/chamados/editar/" . $ticket->getId());
    }

    public function open(?array $data): void
    {
        $page = $data["page"] ?? 1;

        $limit = 10;

        $ticketModel = new Ticket();

        $totalTicketsOpen = $ticketModel->getTicketsByStatus("aberto");

        $paginator = new Paginator(
            url("/admin/chamados/abertos/"),
            "Página"
        );

        $paginator->pager(count($totalTicketsOpen), $limit, $page);

        $tickets = $ticketModel
            ->orderBy("created_at", "DESC")
            ->limit($paginator->limit())
            ->offset($paginator->offset())
            ->get();

        echo $this->view->render('/admin/ticket/open', [
            "title" => "Chamados Cadastrados | " . APP_NAME,
            "tickets" => $tickets,
            "paginator" => $paginator
        ]);
    }
}