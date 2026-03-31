<?php

namespace App\Models;

use App\Core\AbstractModel;
use InvalidArgumentException;
use PDO;

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
        "title" => "O campo TÍTULO é obrigatório.",
        "description" => "O campo DESCRIÇÃO é obrigatório.",
        "school_id" => "O campo ESCOLA é obrigatório.",
        "category_id" => "O campo CATEGORIA é obrigatório.",
        "opened_by" => "O campo PROFESSOR é obrigatório.",
        "status" => "O campo STATUS é obrigatório.",
        "priority" => "O campo PRIORIDADE é obrigatório."
    ];

    protected bool $timestamps = true;

    public const OPEN = "aberto";

    public const IN_PROGRESS = "em_andamento";

    public const WAITING = "aguardando";

    public const RESOLVED = "resolvido";

    public const FINISHED = "finalizado";

    public const ARCHIVED = "arquivado";

    private const STATUS = [
        self::OPEN,
        self::IN_PROGRESS,
        self::WAITING,
        self::RESOLVED,
        self::FINISHED,
        self::ARCHIVED
    ];

    public const LOW = "baixa";

    public const MEAN = "media";

    public const HIGH = "alta";

    private const PRIORITIES = [
        self::LOW,
        self::MEAN,
        self::HIGH
    ];

    public function getId(): ?int
    {
        return $this->attributes["id"] ?? null;
    }

    public function setTitle(string $title): void
    {
        $title = trim(strip_tags($title));

        if (strlen($title) < 10) {
            throw new InvalidArgumentException("O título deve ter pelo menos 10 caracteres.");
        }

        $this->attributes["title"] = $title;
    }

    public function getTitle(): string
    {
        return $this->attributes["title"];
    }

    public function setDescription(string $description): void
    {
        $description = trim(strip_tags($description));

        if (strlen($description) < 30) {
            throw new InvalidArgumentException("A descrição deve ter pelo menos 30 caracteres.");
        }

        $this->attributes["description"] = $description;
    }

    public function getDescription(): string
    {
        return $this->attributes["description"];
    }

    public function setSchoolId(int $schoolId): void
    {
        $this->attributes["school_id"] = $schoolId;
    }

    public function getSchoolId(): int
    {
        return $this->attributes["school_id"];
    }

    public function setCategoryId(int $categoryId): void
    {
        $this->attributes["category_id"] = $categoryId;
    }

    public function getCategoryId(): int
    {
        return (int)$this->attributes["category_id"];
    }

    public function setOpenedBy(int $userId): void
    {
        $this->attributes["opened_by"] = $userId;
    }

    public function getOpenedBy(): int
    {
        return (int)$this->attributes["opened_by"];
    }

    public function setAssignedTo(?int $userId): void
    {
        $this->attributes["assigned_to"] = $userId;
    }

    public function getAssignedTo(): ?int
    {
        return $this->attributes["assigned_to"] ?? null;
    }

    public function setStatus(?string $status): void
    {
        $status = $status ?? self::OPEN;

        if (!in_array($status, self::STATUS)) {
            throw new \InvalidArgumentException("O status é inválido.");
        }

        $this->attributes["status"] = $status;
    }

    public function getStatus(): ?string
    {
        return $this->attributes["status"] ?? null;
    }

    public function setPriority(?string $priority): void
    {
        $priority = $priority ?? self::MEAN;

        if (!in_array($priority, self::PRIORITIES)) {
            throw new \InvalidArgumentException("A prioridade é inválida.");
        }

        $this->attributes["priority"] = $priority;
    }

    public function getPriority(): ?string
    {
        return $this->attributes["priority"] ?? null;
    }

    public function setOpenedAt(): void
    {
        $this->attributes["opened_at"] = (new \DateTimeImmutable("now", new \DateTimeZone(APP_TIMEZONE)))->format("Y-m-d H:i:s");
    }

    public function getOpenedAt(): ?string
    {
        return $this->attributes["opened_at"] ?? null;
    }

    public function setClosedAt(): void
    {
        $this->attributes["closed_at"] = (new \DateTimeImmutable("now", new \DateTimeZone(APP_TIMEZONE)))->format("Y-m-d H:i:s");
    }

    public function getClosedAt(): ?string
    {
        return $this->attributes["closed_at"] ?? null;
    }

    public function school(): ?School
    {
        return $this->getSchoolId() > 0
            ? School::find($this->getSchoolId())
            : null;
    }

    public function category(): ?Category
    {
        return $this->getCategoryId() > 0
            ? Category::find($this->getCategoryId())
            : null;
    }

    public function openedBy(): ?User
    {
        return $this->getOpenedBy() > 0
            ? User::find($this->getOpenedBy())
            : null;
    }

    public function assignedTo(): ?User
    {
        return $this->getAssignedTo() !== null
            ? User::find($this->getAssignedTo())
            : null;
    }

    public function getTicketsByStatus(string $status): array
    {
        return $this->where('status', "=", $status)->get();
    }

    public function allOrdered(int $limit, int $offset): array
    {
        $sql = "SELECT * FROM {$this->table}
            ORDER BY 
                FIELD(status, 'aberto', 'em_andamento', 'aguardando', 'resolvido', 'finalizado', 'arquivado'),
                FIELD(priority, 'alta', 'media', 'baixa'),
                opened_at ASC
            LIMIT :limit OFFSET :offset";

        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':limit', $limit, PDO::PARAM_INT);
        $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();

        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        return array_map(static fn($row) => static::hydrate($row), $rows);
    }

    public function allOrderedByUser(int $userId, int $limit, int $offset): array
    {
        $sql = "SELECT * FROM {$this->table}
            WHERE opened_by = :user_id
            ORDER BY
                FIELD(status, 'aberto', 'em_andamento', 'aguardando', 'resolvido', 'finalizado', 'arquivado'),
                FIELD(priority, 'alta', 'media', 'baixa'),
                opened_at ASC
            LIMIT :limit OFFSET :offset";

        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindParam(':limit', $limit, PDO::PARAM_INT);
        $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();

        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        return array_map(static fn($row) => static::hydrate($row), $rows);
    }

    public function countByMonth(int $year): array
    {
        $sql = "SELECT MONTH(opened_at) as month, COUNT(*) as total
            FROM {$this->table}
            WHERE YEAR(opened_at) = :year
            AND deleted_at IS NULL
            GROUP BY MONTH(opened_at)
            ORDER BY month ASC";

        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':year', $year, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countByCategory(int $year): array
    {
        $sql = "SELECT c.name as category, COUNT(t.id) as total
            FROM {$this->table} t
            INNER JOIN categories c ON c.id = t.category_id
            WHERE YEAR(opened_at) = :year
            AND t.deleted_at IS NULL
            GROUP BY t.category_id, c.name
            ORDER BY total DESC";

        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':year', $year, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}