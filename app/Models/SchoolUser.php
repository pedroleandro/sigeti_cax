<?php

namespace App\Models;

use App\Core\AbstractModel;
use InvalidArgumentException;

class SchoolUser extends AbstractModel
{
    protected string $table = "school_users";
    protected string $primaryKey = "id";
    protected array $fillable = [
        "school_id",
        "user_id",
        "shift"
    ];
    protected array $required = [
        "school_id" => "A escola é obrigatória.",
        "user_id" => "O usuário é obrigatório.",
        "shift" => "O turno é obrigatório."
    ];
    protected bool $timestamps = false;

    public function setSchoolId(int $schoolId): void
    {
        $this->attributes["school_id"] = $schoolId;
    }

    public function setUserId(int $userId): void
    {
        $this->attributes["user_id"] = $userId;
    }

    public function setShift(string $shift): void
    {
        $shifts = ["manha", "tarde", "integral"];
        if (!in_array($shift, $shifts)) {
            throw new InvalidArgumentException("Turno inválido. Use: manha, tarde ou integral.");
        }
        $this->attributes["shift"] = $shift;
    }

    public function getId(): ?int
    {
        return $this->attributes["id"] ?? null;
    }

    public function getSchoolId(): ?int
    {
        return $this->attributes["school_id"] ?? null;
    }

    public function getUserId(): ?int
    {
        return $this->attributes["user_id"] ?? null;
    }

    public function getShift(): ?string
    {
        return $this->attributes["shift"] ?? null;
    }

    public function school(): ?School
    {
        return School::find($this->getSchoolId());
    }

    public function user(): ?User
    {
        return User::find($this->getUserId());
    }

    public static function findByUserAndSchool(int $userId, int $schoolId): ?self
    {
        return (new static())
            ->where("user_id", "=", $userId)
            ->where("school_id", "=", $schoolId)
            ->first();
    }

    public static function validateLinks(array $schools): array
    {
        $schools = self::filterValidLinks($schools);

        if (empty($schools)) {
            return ["Vincule o professor a pelo menos uma escola."];
        }

        $errors = [];
        $shifts  = array_column($schools, "shift");

        if (in_array("integral", $shifts) && count($schools) > 1) {
            $errors[] = "Um professor com turno integral não pode ser vinculado a outra escola em nenhum turno.";
        }

        $shiftCounts = array_count_values($shifts);
        foreach ($shiftCounts as $shift => $count) {
            if ($count > 1) {
                $label    = match ($shift) {
                    "manha"    => "Manhã",
                    "tarde"    => "Tarde",
                    "integral" => "Integral",
                    default    => $shift
                };
                $errors[] = "O turno \"{$label}\" não pode ser usado em mais de uma escola.";
            }
        }

        return $errors;
    }

    private static function filterValidLinks(array $schools): array
    {
        return array_values(
            array_filter($schools, static function ($item) {
                return !empty($item["school_id"]);
            })
        );
    }
}