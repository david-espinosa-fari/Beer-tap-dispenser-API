<?php

namespace Tests\Dispenser\Infrastructure;

use App\Dispenser\Domain\Dispenser;
use App\Dispenser\Domain\Exceptions\DispenserException;
use App\Dispenser\Infrastructure\DispenserRepository\ApcDispenserRepo;
use App\Shared\Uuid\UuidGenerator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\Dispenser\Domain\DispenserTest;
use Tests\Dispenser\Infrastructure\Fakes\FakeThrowApcService;

class ApcDispenserRepoTest extends KernelTestCase
{

    /**
     * @group ApcDispenserRepo
     * @group Integration
     */
    public function testSetup(): ApcDispenserRepo
    {
        self::bootKernel();
        $container = self::$kernel->getContainer();

        $apcDispenserRepo = $container->get(ApcDispenserRepo::class);
        $this->assertInstanceOf(ApcDispenserRepo::class, $apcDispenserRepo);
        return $apcDispenserRepo;
    }

    /**
     * @depends testSetup
     * @group ApcDispenserRepo
     * @group Integration
     * @throws DispenserException
     * @noinspection PhpVoidFunctionResultUsedInspection
     * @noinspection UnnecessaryAssertionInspection
     */
    public function test_should_save_return_void_when_success(ApcDispenserRepo $apcDispenserRepo): void
    {
        $this->assertNull(
            $apcDispenserRepo->save(DispenserTest::createFakeDispenser())
        );

    }

    /**
     * @depends testSetup
     * @group ApcDispenserRepo
     * @group Integration
     * @throws DispenserException
     */
    public function test_save_should_throw_DispenserException_on_error(): void
    {
        $apcDispenserRepo = new ApcDispenserRepo(new FakeThrowApcService(), 23);

        $this->expectException(DispenserException::class);
        $apcDispenserRepo->save(
            DispenserTest::createFakeDispenser()
        );
    }

    /**
     * @depends testSetup
     * @group ApcDispenserRepo
     * @group Integration
     * @throws DispenserException
     */
    public function test_findById_should_return_Dispenser_instance(ApcDispenserRepo $apcDispenserRepo): void
    {
        $dispenserId = UuidGenerator::random();
        $apcDispenserRepo->save(DispenserTest::createFakeDispenser($dispenserId));

        $dispenser = $apcDispenserRepo->findById($dispenserId);
        $this->assertInstanceOf(Dispenser::class, $dispenser);
    }

    /**
     * @depends testSetup
     * @group ApcDispenserRepo
     * @group Integration
     * @throws DispenserException
     */
    public function test_findById_should_throw_DispenserException_when_not_found(ApcDispenserRepo $apcDispenserRepo): void
    {
        $dispenserId = UuidGenerator::random();
        $this->expectException(DispenserException::class);
        $dispenser = $apcDispenserRepo->findById($dispenserId);
    }
}