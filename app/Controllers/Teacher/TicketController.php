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

        $tickets = (new Ticket())->allOrderedByUser(
            Auth::user()->id,
            $paginator->limit(),
            $paginator->offset()
        );

        echo $this->view->render("teacher/ticket/index", [
            "title" => "Dashboard | " . APP_NAME,
            "tickets" => $tickets,
            "paginator" => $paginator,
        ]);
    }

    public function create(?array $data): void
    {
        $user = User::find(Auth::user()->id);
        $userSchools = $user->schools();
        $categories = Category::all();

        echo $this->view->render('/teacher/ticket/create', [
            "title" => "Abrir Novo Chamado | " . APP_NAME,
            "categories" => $categories,
            "userSchools" => $userSchools
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
        $userSchools = $user->schools();

        if (empty($userSchools)) {
            flash("error", "Você não está vinculado a nenhuma escola.");
            redirect("/professor/chamados/cadastrar");
            return;
        }

        // se o professor tiver mais de uma escola, ele precisa ter escolhido no formulário
        if (count($userSchools) > 1) {
            if (empty($data["school_id"])) {
                flash("error", "Selecione a escola para a qual deseja abrir o chamado.");
                redirect("/professor/chamados/cadastrar");
                return;
            }

            // garante que a escola escolhida realmente pertence ao professor
            $validSchoolIds = array_map(fn($link) => $link->getSchoolId(), $userSchools);
            if (!in_array((int)$data["school_id"], $validSchoolIds)) {
                flash("error", "Escola inválida.");
                redirect("/professor/chamados/cadastrar");
                return;
            }

            $schoolId = (int)$data["school_id"];
        } else {
            // professor com vínculo único — pega direto sem precisar escolher
            $schoolId = $userSchools[0]->getSchoolId();
        }

        $data["school_id"] = $schoolId;
        $data["opened_by"] = $user->getId();

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
        } catch (\InvalidArgumentException $e) {
            flash("error", $e->getMessage());
            redirect("/professor/chamados/cadastrar");
            return;
        }

        flash("success", "Chamado aberto com sucesso.");
        redirect("/professor/chamados");
    }
}