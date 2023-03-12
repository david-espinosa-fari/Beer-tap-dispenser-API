<?php


namespace App\Dispenser\Domain;


use App\Dispenser\Domain\Exceptions\StatusException;
use App\Shared\DateTime\AppDateTime;
use App\Shared\HttpCodes\HttpCodes;
use Exception;

class Status
{
    public const OPEN = 'open';
    public const CLOSE = 'close';

    private string $status;

    public function __construct(string $status, AppDateTime $updatedAt)
    {
        switch ($status)
        {
            case self::OPEN:
            case self::CLOSE:
                break;
            default:
                throw new StatusException('The status of the dispenser must be open or close', HttpCodes::BAD_REQUEST);
        }
        $this->updatedAt = $updatedAt;
        $this->status = $status;
    }

    /**
     * @throws StatusException
     * @throws Exception
     */
    public static function build(string $status, $updatedAt = 'now'): Status
    {
        return new self($status, new AppDateTime($updatedAt));
    }
    public function toArray(): array
    {
        return [
            'status' => $this->status,
            'updated_at' => (string)$this->updatedAt,
        ];
    }

    public function whenUpdated():AppDateTime
    {
        return $this->updatedAt;
    }

    public function __toString(): string
    {
        return $this->status;
    }

    public function isOpen(): bool
    {
       return self::OPEN === (string)$this->status;
    }

}