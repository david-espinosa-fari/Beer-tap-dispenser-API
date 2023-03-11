<?php

namespace Tests\Dispenser\Application;

use App\Dispenser\Application\AmountSpent;
use App\Dispenser\Application\Finder\FindDispenserById;
use App\Dispenser\Domain\Spent;
use App\Shared\Uuid\UuidGenerator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\Dispenser\Infrastructure\Fakes\FakeApcDispenserRepo;

class AmountSpentTest extends KernelTestCase
{

    /**
     * @group UnitTest
     */
    public function testSetup(): AmountSpent
    {
        self::bootKernel();
        $spent = self::$kernel->getContainer()->get(AmountSpent::class);
        $this->assertInstanceOf(AmountSpent::class, $spent);
        return $spent;
    }

    /**
     * @group UnitTest
     */
    public function test_should_return_Spent_instance_after_find_dispenser(): void
    {
        $repo = new FakeApcDispenserRepo(); $finder = new FindDispenserById($repo);

        $amountSpent = new AmountSpent($finder);
        $spent = $amountSpent(UuidGenerator::random());

        $this->assertInstanceOf(Spent::class, $spent);
    }
}