<?php
namespace Tests\Dispenser\Application\Finder;

use App\Dispenser\Application\Finder\FindDispenserById;
use App\Dispenser\Domain\Dispenser;
use App\Shared\Uuid\UuidGenerator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\Dispenser\Infrastructure\Fakes\FakeApcDispenserRepo;

class FindDispenserByIdTest extends KernelTestCase
{

    /**
     * @group UnitTest
     */
    public function testSetup(): FindDispenserById
    {
        self::bootKernel();
        $finder = self::$kernel->getContainer()->get(FindDispenserById::class);
        $this->assertInstanceOf(FindDispenserById::class, $finder);
        return $finder;
    }

    /**
     * @group UnitTest
     */
    public function test_should_return_Dispenser_instance_when_found(): void
    {
        $repo = new FakeApcDispenserRepo();
        $finder = new FindDispenserById($repo);

        $this->assertInstanceOf(Dispenser::class, $finder(UuidGenerator::random()));
    }
}