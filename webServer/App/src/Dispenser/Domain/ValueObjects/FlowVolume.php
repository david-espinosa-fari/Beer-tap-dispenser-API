<?php


namespace App\Dispenser\Domain\ValueObjects;


use App\Dispenser\Domain\Exceptions\FlowVolumeException;
use App\Shared\HttpCodes\HttpCodes;

class FlowVolume
{
    /**
     * value is amount of liters spent in seconds litres/second
     * https://rviewer.stoplight.io/docs/beer-tap-dispenser/cb3baa65ed192-returns-the-money-spent-by-the-given-dispenser-id
     * @var float
     */
    private float $value;

    public function __construct($value)
    {
        $this->ensureIsValid($value);
        $this->value = $value;
    }

    public function value(): float
    {
        return $this->value;
    }

    private function ensureIsValid($value): void
    {
        if (!is_float($value))
        {
            throw new FlowVolumeException('Unexpected value type',  HttpCodes::BAD_REQUEST);
        }
    }
}