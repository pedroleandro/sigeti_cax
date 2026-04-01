<?php

namespace App\Models;

use App\Core\AbstractModel;
use InvalidArgumentException;

class Category extends AbstractModel
{
    protected string $table = "categories";

    protected string $primaryKey = "id";

    protected array $fillable = [
        "name",
        "description"
    ];

    protected array $required = [
        "name" => "O campo NOME é obrigatório.",
        "description" => "O campo DESCRIÇÃO é obrigatório."
    ];

    protected bool $timestamps = true;

    protected bool $softDelete = true;

    public function getId(): ?int
    {
        return $this->attributes["id"];
    }

    public function setName(string $name): void
    {
        $name = trim(strip_tags($name));

        if (strlen($name) < 5) {
            throw new InvalidArgumentException("O NOME da categoria deve ter pelo menos 5 caracteres.");
        }

        if (strlen($name) > 100) {
            throw new InvalidArgumentException("O NOME da categoria deve ter no máximo 100 caracteres.");
        }

        $this->attributes["name"] = $name;
    }

    public function getName(): ?string
    {
        return $this->attributes["name"] ?? null;
    }

    public function setDescription(string $description): void
    {
        $description = trim(strip_tags($description));

        if (strlen($description) < 20) {
            throw new InvalidArgumentException("A DESCRIÇÃO da categoria deve ter pelo menos 20 caracteres.");
        }

        if (strlen($description) > 255) {
            throw new InvalidArgumentException("A DESCRIÇÃO da categoria deve ter no máximo 255 caracteres.");
        }

        $this->attributes["description"] = $description;
    }

    public function getDescription(): ?string
    {
        return $this->attributes["description"] ?? null;
    }

    public function findByName(string $name): ?self
    {
        return $this->where("name", "=", $name)->first();
    }
}