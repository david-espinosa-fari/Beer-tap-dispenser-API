<?php

namespace Tests\Dispenser\Application;

use App\Dispenser\Application\CreateDispenser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\Dispenser\Domain\DispenserTest;
use Tests\Dispenser\Infrastructure\Fakes\FakeApcDispenserRepo;

class CreateDispenserTest extends KernelTestCase
{

    /**
     * @group UnitTest
     */
    public function testSetup(): CreateDispenser
    {
        self::bootKernel();
        $spent = self::$kernel->getContainer()->get(CreateDispenser::class);
        $this->assertInstanceOf(CreateDispenser::class, $spent);
        return $spent;
    }

    /**
     * @group UnitTest
     */
    public function test_should_return_void_on_successfully_save(): void
    {
        $repo = new FakeApcDispenserRepo();
        $creator = new CreateDispenser($repo);

        $this->assertNull($creator(DispenserTest::createFakeDispenser()));
    }
}