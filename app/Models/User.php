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
        "name" => "O nome é obrigatório.",
        "email" => "O email é obrigatório.",
        "password" => "A senha é obrigatória."
    ];
    protected bool $timestamps = true;

    public function setName(string $name): void
    {
        $name = trim($name);
        if (strlen($name) < 3) {
            throw new \InvalidArgumentException("O nome deve ter pelo menos 3 caracteres");
        }
        $this->attributes["name"] = $name;
    }

    public function setEmail(string $email): void
    {
        $email = filter_var(trim($email), FILTER_VALIDATE_EMAIL);
        if (!$email) {
            throw new \InvalidArgumentException("E-mail inválido");
        }
        $this->attributes["email"] = $email;
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

    public function setRole(string $role): void
    {
        $roles = ["professor", "tecnico"];
        if (!in_array($role, $roles)) {
            throw new \InvalidArgumentException("Perfil inválido");
        }
        $this->attributes["role"] = $role;
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

    public function setLastLoginAt(?string $date): void
    {
        $this->attributes["last_login_at"] = $date;
    }

    public function getId(): ?int
    {
        return $this->attributes["id"] ?? null;
    }

    public function getName(): ?string
    {
        return $this->attributes["name"] ?? null;
    }

    public function getEmail(): ?string
    {
        return $this->attributes["email"] ?? null;
    }

    public function getDocument(): ?string
    {
        return $this->attributes["document"] ?? null;
    }

    public function getRole(): ?string
    {
        return $this->attributes["role"] ?? null;
    }

    public function getStatus(): ?string
    {
        return $this->attributes["status"] ?? null;
    }

    public function getLastLogin(): mixed
    {
        return $this->attributes["last_login_at"] ?? null;
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->attributes["password"] ?? "");
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
}