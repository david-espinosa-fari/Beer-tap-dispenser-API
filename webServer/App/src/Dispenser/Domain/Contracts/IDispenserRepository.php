<?php
namespace App\Dispenser\Domain\Contracts;

use App\Dispenser\Domain\Dispenser;
use App\Dispenser\Domain\Status;

interface IDispenserRepository
{
    public function save(Dispenser $dispenser): void;

    public function findById(string $dispenserId): Dispenser;


}