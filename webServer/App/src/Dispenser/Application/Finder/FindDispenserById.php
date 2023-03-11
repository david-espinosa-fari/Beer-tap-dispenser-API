<?php

namespace App\Dispenser\Application\Finder;

use App\Dispenser\Domain\Contracts\IDispenserRepository;
use App\Dispenser\Domain\Dispenser;

class FindDispenserById
{

    /**
     * @var IDispenserRepository
     */
    private IDispenserRepository $repo;

    public function __construct(IDispenserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function __invoke(string $dispenserId): Dispenser
    {
        return $this->repo->findById($dispenserId);
    }
}