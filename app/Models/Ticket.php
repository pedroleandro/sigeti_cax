<?php
namespace App\Models;

use App\Core\AbstractModel;
use InvalidArgumentException;

class Ticket extends AbstractModel
{
    protected string $table = "tickets";
    protected string $primaryKey = "id";
    protected array $fillable = [
        "title",
        "description",
        "school_id",
        "category_id",
        "opened_by",
        "assigned_to",
        "status",
        "priority",
        "opened_at",
        "closed_at",
    ];
    protected array $required = [
        "title"       => "O título do chamado é obrigatório.",
        "description" => "A descrição do chamado é obrigatória.",
        "school_id"   => "A escola é obrigatória.",
        "category_id" => "A categoria é obrigatória.",
        "opened_by"   => "O professor é obrigatório"
    ];
    protected bool $timestamps = true;

    public function setTitle(string $title): void
    {
        $title = trim(strip_tags($title));
        if (strlen($title) < 10) {
            throw new InvalidArgumentException("O título deve ter pelo menos 10 caracteres.");
        }
        $this->attributes["title"] = $title;
    }

    public function setDescription(string $description): void
    {
        $description = trim(strip_tags($description));
        if (strlen($description) < 30) {
            throw new InvalidArgumentException("A descrição deve ter pelo menos 30 caracteres.");
        }
        $this->attributes["description"] = $description;
    }

    public function setSchoolId(int $schoolId): void
    {
        $this->attributes["school_id"] = $schoolId;
    }

    public function setCategoryId(int $categoryId): void
    {
        $this->attributes["category_id"] = $categoryId;
    }

    public function setOpenedBy(int $userId): void
    {
        $this->attributes["opened_by"] = $userId;
    }

    public function setAssignedTo(?int $userId): void
    {
        $this->attributes["assigned_to"] = $userId;
    }

    public function setStatus(string $status): void
    {
        $statuses = ['aberto', 'em_andamento', 'aguardando', 'resolvido', 'finalizado', 'arquivado'];
        if (!in_array($status, $statuses)) {
            throw new InvalidArgumentException("Status inválido.");
        }
        $this->attributes["status"] = $status;
    }

    public function setPriority(string $priority): void
    {
        $priorities = ["alta", "media", "baixa"];
        if (!in_array($priority, $priorities)) {
            throw new InvalidArgumentException("Prioridade inválida.");
        }
        $this->attributes["priority"] = $priority;
    }

    public function setOpenedAt(?string $date): void
    {
        $this->attributes["opened_at"] = $date;
    }

    public function setClosedAt(?string $date): void
    {
        $this->attributes["closed_at"] = $date;
    }

    public function getId(): ?int
    {
        return $this->attributes["id"] ?? null;
    }

    public function getTitle(): ?string
    {
        return $this->attributes["title"] ?? null;
    }

    public function getDescription(): ?string
    {
        return $this->attributes["description"] ?? null;
    }

    public function getSchoolId(): ?int
    {
        return $this->attributes["school_id"] ?? null;
    }

    public function getCategoryId(): ?int
    {
        return $this->attributes["category_id"] ?? null;
    }

    public function getOpenedBy(): ?int
    {
        return $this->attributes["opened_by"] ?? null;
    }

    public function getAssignedTo(): ?int
    {
        return $this->attributes["assigned_to"] ?? null;
    }

    public function getStatus(): ?string
    {
        return $this->attributes["status"] ?? null;
    }

    public function getPriority(): ?string
    {
        return $this->attributes["priority"] ?? null;
    }

    public function getOpenedAt(): ?string
    {
        return $this->attributes["opened_at"] ?? null;
    }

    public function getClosedAt(): ?string
    {
        return $this->attributes["closed_at"] ?? null;
    }

    public function school(): ?School
    {
        return $this->getSchoolId()
            ? School::find($this->getSchoolId())
            : null;
    }

    public function category(): ?Category
    {
        return $this->getCategoryId()
            ? Category::find($this->getCategoryId())
            : null;
    }

    public function openedBy(): ?User
    {
        return $this->getOpenedBy()
            ? User::find($this->getOpenedBy())
            : null;
    }

    public function assignedTo(): ?User
    {
        return $this->getAssignedTo()
            ? User::find($this->getAssignedTo())
            : null;
    }

    public function getTicketsByStatus(string $status): array
    {
        return $this->where('status', "=", $status)->get();
    }
}