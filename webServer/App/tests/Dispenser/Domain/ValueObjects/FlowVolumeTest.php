<?php


namespace Tests\Dispenser\Domain\ValueObjects;


use App\Dispenser\Domain\Exceptions\FlowVolumeException;
use App\Dispenser\Domain\ValueObjects\FlowVolume;
use PHPUnit\Framework\TestCase;

class FlowVolumeTest extends TestCase
{

    /**
     * @group UnitTest
     */
    public function testSetup(): FlowVolume
    {
        $dispenser = new FlowVolume(0.123);

        $this->assertInstanceOf(FlowVolume::class, $dispenser);

        return $dispenser;
    }

    /**
     * @depends testSetup
     * @group UnitTest
     * @param FlowVolume $flowVolume
     */
    public function test_should_return_value_float(FlowVolume $flowVolume): void
    {
        $this->assertIsFloat($flowVolume->value());
    }

    /**
     * @depends testSetup
     * @group UnitTest
     * @param FlowVolume $flowVolume
     */
    public function test_should_throw_exception_on_invalid_type(FlowVolume $flowVolume): void
    {
        $this->expectException(FlowVolumeException::class);
        new FlowVolume('lerele');
        $this->assertIsFloat($flowVolume->value());
    }
}