<?php

namespace App\Dispenser\Infrastructure\Responses;

use App\Dispenser\Domain\Contracts\IFormatDispenserResponse;
use App\Dispenser\Domain\Dispenser;

class DispenserWithOutStateResponse implements IFormatDispenserResponse
{

    public function __invoke(Dispenser $dispenser): array
    {
        $dispenserWithOutStates = $dispenser->toArray();
        unset($dispenserWithOutStates['states']);
        return $dispenserWithOutStates;
    }
}