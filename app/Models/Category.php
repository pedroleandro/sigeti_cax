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

    protected bool $timestamps = true;

    public function setName(string $name): void
    {
        $name = trim($name);

        if (strlen($name) < 3) {
            throw new InvalidArgumentException("A categoria deve ter pelo menos 3 caracteres.");
        }

        $this->attributes["name"] = $name;
    }

    public function setDescription(string $description): void
    {
        $description = trim($description);

        if (strlen($description) < 12) {
            throw new InvalidArgumentException("A descrição deve ter pelo menos 12 caracteres.");
        }

        $this->attributes["description"] = $description;
    }

    public function getId()
    {
        return $this->attributes["id"];
    }

    public function getName(): string
    {
        return $this->attributes["name"];
    }

    public function getDescription(): string
    {
        return $this->attributes["description"];
    }
}