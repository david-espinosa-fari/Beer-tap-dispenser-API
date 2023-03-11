<?php
namespace Tests\Dispenser\Infrastructure\Fakes;

use App\Dispenser\Domain\Contracts\IDispenserRepository;
use App\Dispenser\Domain\Dispenser;
use Tests\Dispenser\Domain\DispenserTest;

class FakeApcDispenserRepo implements IDispenserRepository
{

    public function save(Dispenser $dispenser): void
    {
        // TODO: Implement save() method.
    }

    public function findById(string $dispenserId): Dispenser
    {
        return DispenserTest::createFakeDispenser($dispenserId);
    }

}