<?php

namespace App\Dispenser\Application;

use App\Dispenser\Application\Finder\FindDispenserById;
use App\Dispenser\Domain\Spent;

class AmountSpent
{
    private FindDispenserById $finder;

    public function __construct(FindDispenserById $finder)
    {
        $this->finder = $finder;
    }

    public function __invoke(string $dispenserId): Spent
    {
        $dispenser = $this->finder->__invoke($dispenserId);

        return new Spent($dispenser);
    }
}