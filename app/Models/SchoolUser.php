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
        "school_id" => "O campo ESCOLA é obrigatório.",
        "user_id" => "O campo USER é obrigatório.",
        "shift" => "O campo TURNO é obrigatório.",
    ];

    protected bool $timestamps = false;

    public const MORNING = "manha";

    public const AFTERNOON = "tarde";

    public const WHOLE = "integral";

    private const SHIFTS = [
        self::MORNING,
        self::AFTERNOON,
        self::WHOLE
    ];

    public function getId(): ?int
    {
        return $this->attributes["id"];
    }

    public function setSchoolId(int $schoolId): void
    {
        $this->attributes["school_id"] = $schoolId;
    }

    public function getSchoolId(): ?int
    {
        return $this->attributes["school_id"] ?? null;
    }

    public function setUserId(int $userId): void
    {
        $this->attributes["user_id"] = $userId;
    }

    public function getUserId(): ?int
    {
        return $this->attributes["user_id"] ?? null;
    }

    public function setShift(?string $shift): void
    {
        $shift = $shift ?? self::WHOLE;

        if (!in_array($shift, self::SHIFTS)) {
            throw new \InvalidArgumentException("O Turno é inválido.");
        }

        $this->attributes["shift"] = $shift;

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
        $shifts = array_column($schools, "shift");

        if (in_array(self::WHOLE, self::SHIFTS) && count($schools) > 1) {
            $errors[] = "Um professor com turno integral não pode ser vinculado a outra escola em nenhum turno.";
        }

        $shiftCounts = array_count_values($shifts);
        foreach ($shiftCounts as $shift => $count) {
            if ($count > 1) {
                $label = match ($shift) {
                    "manha" => "Manhã",
                    "tarde" => "Tarde",
                    "integral" => "Integral",
                    default => $shift
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