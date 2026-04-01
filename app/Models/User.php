<?php

namespace App\Models;

use App\Core\AbstractModel;

class User extends AbstractModel
{
    protected string $table = "users";
    protected string $primaryKey = "id";
    protected array $fillable = [
        "name",
        "email",
        "password",
        "document",
        "role",
        "last_login_at",
        "status"
    ];

    protected array $required = [
        "name" => "O campo NOME é obrigatório.",
        "email" => "O campo EMAIL é obrigatório.",
        "password" => "O campo SENHA é obrigatório."
    ];

    protected bool $timestamps = true;

    protected bool $softDelete = true;

    public const TEACHER = "professor";
    public const TECHNICIAN = "tecnico";

    private const ROLES = [
        self::TEACHER,
        self::TECHNICIAN
    ];

    public const REGISTERED = "registrado";
    public const ACTIVE = "ativo";
    public const INACTIVE = "inativo";
    private const STATUS = [
        self::REGISTERED,
        self::ACTIVE,
        self::INACTIVE
    ];

    public function getId(): ?int
    {
        return $this->attributes["id"];
    }

    public function setName(string $name): void
    {
        $name = trim(strip_tags($name));
        if (strlen($name) < 3) {
            throw new \InvalidArgumentException("O nome deve ter pelo menos 3 caracteres");
        }
        $this->attributes["name"] = $name;
    }

    public function getName(): ?string
    {
        return $this->attributes["name"] ?? null;
    }

    public function setEmail(string $email): void
    {
        $email = filter_var(trim($email), FILTER_VALIDATE_EMAIL);
        if (!$email) {
            throw new \InvalidArgumentException("E-mail inválido");
        }
        $this->attributes["email"] = $email;
    }

    public function getEmail(): ?string
    {
        return $this->attributes["email"] ?? null;
    }

    public function setPassword(?string $password): void
    {
        if ($password === null || $password === "") {
            return;
        }
        if (strlen($password) < 6) {
            throw new \InvalidArgumentException("A senha deve ter pelo menos 6 caracteres.");
        }
        $this->attributes["password"] = password_hash($password, PASSWORD_DEFAULT);
    }

    public function setDocument(?string $document): void
    {
        if ($document) {
            $document = preg_replace('/[^0-9]/', '', $document);
            if (strlen($document) !== 11) {
                throw new \InvalidArgumentException("Documento inválido");
            }
        }
        $this->attributes["document"] = $document;
    }

    public function getDocument(): ?string
    {
        return $this->attributes["document"] ?? null;
    }

    public function setRole(string $role): void
    {
        $roles = ["professor", "tecnico"];
        if (!in_array($role, $roles)) {
            throw new \InvalidArgumentException("Perfil inválido");
        }
        $this->attributes["role"] = $role;
    }

    public function getRole(): ?string
    {
        return $this->attributes["role"] ?? null;
    }

    public function setStatus(?string $status): void
    {
        $status = $status ?? "ativo";
        $statuses = ["registrado", "ativo", "inativo"];
        if (!in_array($status, $statuses)) {
            throw new \InvalidArgumentException("Status inválido");
        }
        $this->attributes["status"] = $status;
    }

    public function getStatus(): ?string
    {
        return $this->attributes["status"] ?? null;
    }

    public function setLastLoginAt(): void
    {
        $timezone = new \DateTimeZone($_ENV['APP_TIMEZONE'] ?? 'America/Sao_Paulo');
        $now = new \DateTimeImmutable('now', $timezone);
        $this->attributes["last_login_at"] = $now->format('Y-m-d H:i:s');
    }

    public function getLastLogin(): mixed
    {
        return $this->attributes["last_login_at"] ?? null;
    }

    public function passwordVerify(string $password): bool
    {
        return password_verify($password, $this->attributes["password"] ?? null);
    }

    public static function findByEmail(string $email): ?self
    {
        return (new static())
            ->where("email", "=", $email)
            ->first();
    }

    public function schools(): array
    {
        return (new SchoolUser())
            ->where("user_id", "=", $this->getId())
            ->get();
    }

    public function hasMultipleSchools(): bool
    {
        return count($this->schools()) > 1;
    }

    public static function teachers(): ?array
    {
        return (new static)->where("role", "=", self::TEACHER)->get();
    }

    public static function technicians(): ?array
    {
        return (new static)->where("role", "=", self::TECHNICIAN)->get();
    }
}