<?php

namespace App\Shared\DateTime;

use DateTime;
use DateTimeZone;

class AppDateTime extends DateTime
{
    public function __construct ($time='now', DateTimeZone $timezone=null)
    {
        parent::__construct($time, $timezone ?? new DateTimeZone('Europe/Madrid'));
    }

    public function __toString(): string
    {
        return $this->format(self::ATOM);
    }
}