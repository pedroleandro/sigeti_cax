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
        "name" => "O nome é obrigatório",
        "description" => "A descrição é obrigatória"
    ];

    protected bool $timestamps = true;

    public function setName(string $name): void
    {
        $name = trim(strip_tags($name));
        if (strlen($name) < 5) {
            throw new InvalidArgumentException("A categoria deve ter pelo menos 5 caracteres.");
        }
        $this->attributes["name"] = $name;
    }

    public function setDescription(string $description): void
    {
        $description = trim(strip_tags($description));
        if (strlen($description) < 20) {
            throw new InvalidArgumentException("A descrição deve ter pelo menos 20 caracteres.");
        }
        $this->attributes["description"] = $description;
    }

    public function getId(): ?int
    {
        return $this->attributes["id"] ?? null;
    }

    public function getName(): ?string
    {
        return $this->attributes["name"] ?? null;
    }

    public function getDescription(): ?string
    {
        return $this->attributes["description"] ?? null;
    }
}