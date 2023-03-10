<?php
namespace Tests\Shared\Uuid;

use App\Shared\Uuid\UuidGenerator;
use Exception;
use PHPUnit\Framework\TestCase;

class UuidGeneratorTest extends TestCase
{

    /**
     * @group Integration
     * @group ExternalResource
     */
    public function test_random_should__return_instanceOf_UuidGenerator(): UuidGenerator
    {
        $dispenser = UuidGenerator::random();
        $this->assertInstanceOf(UuidGenerator::class, $dispenser);
        return $dispenser;
    }

    /**
     * @depends test_random_should__return_instanceOf_UuidGenerator
     * @group Integration
     * @param UuidGenerator $uuidGenerator
     */
    public function test_call_it_as_string_should_return_a_valid_uuid(UuidGenerator $uuidGenerator): void
    {
        $this->assertIsString((string)$uuidGenerator);

        $uuid = new UuidGenerator((string)$uuidGenerator);
        $this->assertInstanceOf(UuidGenerator::class, $uuid);
    }

    /**
     * @group Integration
     */
    public function test_should_throw_exception_on_invalid_uuid(): void
    {
        $this->expectException(Exception::class);
        $uuid = new UuidGenerator('invalid-Uuid');
    }
}