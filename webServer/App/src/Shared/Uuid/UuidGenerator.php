<?php
namespace App\Shared\Uuid;

use Exception;
use Ramsey\Uuid\Uuid;

class UuidGenerator
{
    private string $value;

    public function __construct(string $value)
    {
        $this->ensureIsValidUuid($value);

        $this->value = $value;
    }

    public static function random(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    private function value(): string
    {
        return $this->value;
    }

    private function ensureIsValidUuid($id): void
    {
        if (!Uuid::isValid($id)) {
            throw new Exception(
                sprintf('<%s> does not allow the value <%s>.', static::class, is_scalar($id) ? $id : gettype($id))
            );
        }
    }

    public function __toString()
    {
        return $this->value();
    }
}