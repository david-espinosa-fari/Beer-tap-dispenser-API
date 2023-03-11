<?php

namespace Tests\Dispenser\Domain;

use App\Dispenser\Domain\Exceptions\StatusException;
use App\Dispenser\Domain\Status;
use PHPUnit\Framework\TestCase;

class StatusTest extends TestCase
{

    /**
     * @group UnitTest
     */
    public function testSetup(): Status
    {
        $status = self::createFakeStatus();
        $this->assertInstanceOf(Status::class, $status);

        return $status;
    }

    /**
     * @group UnitTest
     */
    public function test_should_trow_when_status_is_not_open_or_close(): void
    {
        $this->expectException(StatusException::class);
        self::createFakeStatus('unexistant status');
    }

    /**
     * @group UnitTest
     */
    public function test_isOpen_should_return_truw_if_status_is_open(): void
    {
        $status = self::createFakeStatus(Status::OPEN);
        $this->assertTrue($status->isOpen());
    }
    /**
     * @depends testSetup
     * @group UnitTest
     */
    public function test_toArray_should_have_keys(Status $status): void
    {
        $array = $status->toArray();
        $this->assertIsArray($array);
        $this->assertArrayHasKey('status', $array);
        $this->assertArrayHasKey('updated_at', $array);
        $this->assertCount(2, $array);
    }

    /**
     * @group UnitTest
     */
    public static function createFakeStatus(string $status = 'open'): Status
    {
        //sleep(1);
        return Status::build($status);
    }
}