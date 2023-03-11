<?php

namespace Tests\Dispenser\Application;

use App\Dispenser\Application\Finder\FindDispenserById;
use App\Dispenser\Application\UpdateDispenserStatus;
use App\Dispenser\Domain\Status;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\Dispenser\Domain\DispenserTest;
use Tests\Dispenser\Domain\StatusTest;
use Tests\Dispenser\Infrastructure\Fakes\FakeApcDispenserRepo;

class UpdateDispenserStatusTest extends KernelTestCase
{

    /**
     * @group UnitTest
     */
    public function testSetup(): UpdateDispenserStatus
    {
        self::bootKernel();
        $spent = self::$kernel->getContainer()->get(UpdateDispenserStatus::class);
        $this->assertInstanceOf(UpdateDispenserStatus::class, $spent);
        return $spent;
    }

    /**
     * @group UnitTest
     */
    public function test_should_return_void_on_successfully_update(): void
    {
        $repo = new FakeApcDispenserRepo();
        $finder = new FindDispenserById($repo);

        $update = new UpdateDispenserStatus($repo, $finder);

        $dispenser = DispenserTest::createFakeDispenser();
        $status = StatusTest::createFakeStatus(Status::OPEN);

        $this->assertNull($update($dispenser, $status));

    }
}