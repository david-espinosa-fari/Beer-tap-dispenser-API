<?php

namespace App\Dispenser\Application;

use App\Dispenser\Application\Finder\FindDispenserById;
use App\Dispenser\Domain\Contracts\IDispenserRepository;
use App\Dispenser\Domain\Exceptions\StatusException;
use App\Dispenser\Domain\Status;

class UpdateDispenserStatus
{

    private IDispenserRepository $repo;
    private FindDispenserById $finder;

    public function __construct(IDispenserRepository $repo, FindDispenserById $finder)
    {
        $this->repo = $repo;
        $this->finder = $finder;
    }

    /**
     * @throws StatusException
     */
    public function __invoke(string $dispenserId, Status $status): void
    {
        $dispenser = $this->finder->__invoke($dispenserId);
        $dispenser->addNewStatus($status);

        $this->repo->save($dispenser);
    }

}