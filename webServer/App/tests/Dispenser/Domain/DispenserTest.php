<?php

namespace Tests\Dispenser\Domain;

use App\Dispenser\Domain\Dispenser;
use App\Dispenser\Domain\Exceptions\StatusException;
use App\Dispenser\Domain\Status;
use App\Dispenser\Domain\ValueObjects\FlowVolume;
use App\Shared\Uuid\UuidGenerator;
use PHPUnit\Framework\TestCase;

class DispenserTest extends TestCase
{

    /**
     * @group UnitTest
     */
    public function testSetup(): Dispenser
    {
        $dispenser = self::createFakeDispenser();
            $this->assertInstanceOf(Dispenser::class, $dispenser);

        return $dispenser;
    }

    /**
     * @depends testSetup
     * @group UnitTest
     * @param Dispenser $dispenser
     * @throws StatusException
     */
    public function test_toArray_should_return_array_with_keys(Dispenser $dispenser): void
    {
        $array = $dispenser->toArray();
        $this->assertIsArray($array);
        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('flow_volume', $array);
        $this->assertArrayHasKey('states', $array);
        $this->assertCount(3, $array);
    }

    /**
     * @depends testSetup
     * @group UnitTest
     * @param Dispenser $dispenser
     */
    public function test_getFlowVolume_should_return_insanceOf_FlowVolume(Dispenser $dispenser): void
    {
        $flow = $dispenser->getFlowVolume();
        $this->assertInstanceOf(FlowVolume::class, $flow);
    }

    /**
     * @depends testSetup
     * @group UnitTest
     */
    public function test_should_trow_exception_when_repet_state(): void
    {
        $this->expectException(StatusException::class);
        $dispenser = DispenserTest::createFakeDispenser(UuidGenerator::random());
        $dispenser->addNewStatus(Status::build(Status::OPEN));
        sleep(1);
        $dispenser->addNewStatus(Status::build(Status::OPEN));
    }

    public static function createFakeDispenser(string $dispenserId = null): Dispenser
    {
        return Dispenser::build(
            $dispenserId ?? UuidGenerator::random(),
            0.123,
            [Status::build(Status::CLOSE)]
        );
    }
}