<?php

namespace App\Controllers\Teacher;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use CoffeeCode\Paginator\Paginator;

class TicketController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");

        Auth::requireRole("professor");
    }

    public function index(?array $data): void
    {
        $page = $data["page"] ?? 1;

        $limit = 10;

        $ticketModel = new Ticket();

        $total = $ticketModel->where('opened_by', '=', Auth::user()->id)->count();

        $paginator = new Paginator(
            url("/professor/dashboard/"),
            "Página"
        );

        $paginator->pager($total, $limit, $page);

        $tickets = $ticketModel
            ->where('opened_by', '=', Auth::user()->id)
            ->orderBy("created_at", "DESC")
            ->limit($paginator->limit())
            ->offset($paginator->offset())
            ->get();

        echo $this->view->render("teacher/ticket/index", [
            "title" => "Dashboard | " . APP_NAME,
            "tickets" => $tickets,
            "paginator" => $paginator,
        ]);
    }

    public function create(?array $data): void
    {
        $categories = Category::all();

        echo $this->view->render('/teacher/ticket/create', [
            "title" => "Abrir Novo Chamado | " . APP_NAME,
            "categories" => $categories
        ]);
    }

    public function store(?array $data): void
    {
        if (!$data || !csrf_verify($data["_csrf"] ?? null)) {
            flash("error", "Token de segurança inválido.");
            redirect("/professor/chamados/cadastrar");
            return;
        }

        $user = User::find(Auth::user()->id);
        $data['school_id'] = $user->school()->getId();
        $data['opened_by'] = $user->getId();

        $ticket = new Ticket();

        $errors = $ticket->validate($data);

        if ($errors) {
            flash("error", implode("<br>", $errors));
            redirect("/professor/chamados/cadastrar");
            return;
        }

        try {
            $ticket->fill([
                "title" => $data["title"],
                "description" => $data["description"],
                "category_id" => $data["category_id"],
                "school_id" => $data["school_id"],
                "opened_by" => $data["opened_by"],
                "status" => "aberto"
            ]);

            $ticket->save();

        } catch (\InvalidArgumentException $exception) {

            flash("error", $exception->getMessage());
            redirect("/professor/chamados/cadastrar");
            return;
        }

        flash("success", "Chamado aberto com sucesso.");
        redirect("/professor/chamados");
        return;
    }
}