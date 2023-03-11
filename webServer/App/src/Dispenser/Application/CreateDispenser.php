<?php
namespace App\Dispenser\Application;

use App\Dispenser\Domain\Contracts\IDispenserRepository;
use App\Dispenser\Domain\Dispenser;

class CreateDispenser
{

    private IDispenserRepository $repo;

    public function __construct(IDispenserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function __invoke(Dispenser $dispenser): void
    {
        $this->repo->save($dispenser);
    }
}