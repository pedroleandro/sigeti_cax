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
    protected array $required = [
        "name" => "O nome é obrigatorio",
        "code" => "O código é obrigatorio",
        "address" => "O endereço é obrigatorio"
    ];
    protected bool $timestamps = true;

    public function setName(string $name): void
    {
        $name = trim(strip_tags($name));
        if (strlen($name) < 15) {
            throw new InvalidArgumentException("O nome da escola deve ter pelo menos 15 caracteres.");
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
        $address = trim(strip_tags($address));
        if (strlen($address) < 20) {
            throw new InvalidArgumentException("O endereço da escola deve ter pelo menos 20 caracteres.");
        }
        $this->attributes["address"] = $address;
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

    public function users(): array
    {
        return (new SchoolUser())
            ->where("school_id", "=", $this->getId())
            ->get();
    }
}