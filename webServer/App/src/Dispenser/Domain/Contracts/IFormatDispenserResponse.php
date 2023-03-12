<?php

namespace App\Dispenser\Domain\Contracts;

use App\Dispenser\Domain\Dispenser;

interface IFormatDispenserResponse
{
    public function __invoke(Dispenser $dispenser): array;

}