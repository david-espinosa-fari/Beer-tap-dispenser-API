<?php

namespace Tests\Dispenser\Domain;

use App\Dispenser\Domain\Spent;
use App\Dispenser\Domain\Status;
use App\Shared\Uuid\UuidGenerator;
use PHPUnit\Framework\TestCase;

class SpentTest extends TestCase
{

    /**
     * @group UnitTest
     */
    public function testSetup(): Spent
    {
        $dispenser = DispenserTest::createFakeDispenser(UuidGenerator::random());
        $dispenser->addNewStatus(Status::build(Status::OPEN));
        sleep(1);
        $dispenser->addNewStatus(Status::build(Status::CLOSE));
        sleep(1);
        $dispenser->addNewStatus(Status::build(Status::OPEN));

        $spent = new Spent(
            $dispenser
        );
        $this->assertInstanceOf(Spent::class, $spent);

        return $spent;
    }

    /**
     * @depends testSetup
     * @group UnitTest
     */
    public function test_toArray_should_return_array_with_keys(Spent $spent): void
    {
        $array = $spent->toArray();
        $this->assertIsArray($array);
        $this->assertArrayHasKey('amount', $array);
        $this->assertArrayHasKey('usages', $array);
        $this->assertCount(2, $array);
    }
    /**
     * @depends testSetup
     * @group UnitTest
     */
    public function test_should_exist_several_usages(Spent $spent): void
    {
        $array = $spent->toArray();
        $this->assertIsArray($array['usages']);
        $this->assertCount(2, $array['usages']);
    }



}