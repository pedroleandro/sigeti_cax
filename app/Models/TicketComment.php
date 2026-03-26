<?php

namespace App\Models;

use App\Core\AbstractModel;

class TicketComment extends AbstractModel
{
    protected string $table = "tickets_comments";

    protected string $primaryKey = "id";

    protected array $fillable = [
        "ticket_id",
        "user_id",
        "comment"
    ];

    protected array $required = [
        "ticket_id" => "O campo CHAMADO é obrigatório.",
        "user_id" => "O campo USUÁRIO é obrigatório.",
        "comment" => "O campo COMENTÁRIO é obrigatório."
    ];

    protected bool $timestamps = false;

    public function getId(): int
    {
        return $this->attributes["id"];
    }

    public function setTicketId(int $ticketId): void
    {
        $this->attributes["ticket_id"] = $ticketId;
    }

    public function getTicketId(): ?int
    {
        return $this->attributes["ticket_id"] ?? null;
    }

    public function setUserId(int $userId): void
    {
        $this->attributes["user_id"] = $userId;
    }

    public function getUserId(): ?int
    {
        return $this->attributes["user_id"] ?? null;
    }

    public function setComment(string $comment): void
    {
        $comment = trim(strip_tags($comment));

        if (strlen($comment) < 10) {
            throw new \InvalidArgumentException("O comentário deve ter pelo menos 10 caracteres.");
        }

        $this->attributes["comment"] = $comment;
    }

    public function getComment(): ?string
    {
        return $this->attributes["comment"] ?? null;
    }

    public function ticket(): ?Ticket
    {
        return $this->getTicketId()
            ? Ticket::find($this->getTicketId())
            : null;
    }

    public function user(): ?User
    {
        return $this->getUserId()
            ? User::find($this->getUserId())
            : null;
    }

    public static function findByTicket(int $ticketId): array
    {
        return (new static())
            ->where("ticket_id", "=", $ticketId)
            ->orderBy("created_at", "ASC")
            ->get();
    }
}