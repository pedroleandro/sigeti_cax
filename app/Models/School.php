<?php

namespace App\Models;

use App\Core\AbstractModel;
use InvalidArgumentException;

class School extends AbstractModel
{
    protected string $table = "schools";

    protected string $primaryKey = "id";

    protected array $fillable = [
        "name",
        "code",
        "address"
    ];

    protected bool $timestamps = true;

    public function setName(string $name): void
    {
        $name = trim($name);

        if (strlen($name) < 10) {
            throw new InvalidArgumentException("A escola deve ter pelo menos 10 caracteres.");
        }

        $this->attributes["name"] = $name;
    }

    public function setCode(string $code): void
    {
        $code = trim($code);

        if (strlen($code) !== 8) {
            throw new InvalidArgumentException("O código da escola deve ter exatamente 8 caracteres.");
        }

        $this->attributes["code"] = $code;
    }

    public function setAddress(string $address): void
    {
        $this->attributes["address"] = trim($address);
    }

    public function getId(): ?int
    {
        return $this->attributes["id"] ?? null;
    }

    public function getName(): ?string
    {
        return $this->attributes["name"] ?? null;
    }

    public function getCode(): ?string
    {
        return $this->attributes["code"] ?? null;
    }

    public function getAddress(): ?string
    {
        return $this->attributes["address"] ?? null;
    }
}