<?php

namespace Tests\Dispenser\Domain;

use App\Dispenser\Domain\Exceptions\StatusException;
use App\Dispenser\Domain\StateCollection;
use App\Dispenser\Domain\Status;
use App\Shared\DateTime\AppDateTime;
use PHPUnit\Framework\TestCase;

class StateCollectionTest extends TestCase
{

    /**
     * @group UnitTest
     */
    public function test_should_trow_StatusException_on_invalid_state_in_array(): void
    {
        $this->expectException(StatusException::class);

        new StateCollection([
            StatusTest::createFakeStatus(),
            'lerele'
        ]);
    }
    /**
     * @group UnitTest
     */
    public function test_should_trow_StatusException_on_equals_Sates_when_add(): void
    {
        $this->expectException(StatusException::class);

        $collection = new StateCollection([
            StatusTest::createFakeStatus('open')
        ]);
        $collection->add(
            StatusTest::createFakeStatus('open')
        );
    }

    /**
     * @group UnitTest
     * @throws StatusException
     */
    public function test_should_trow_StatusException_given_new_state_time_smaller_than_last_registered_state(): void
    {
        $collection = new StateCollection([
            StatusTest::createFakeStatus('open')
        ]);
        //$oldest It is what happen first. so in order to force the exception, will be inserted last
        $oldestState = StatusTest::createFakeStatus('open');
        sleep(1);
        $newerState = StatusTest::createFakeStatus('close');

        $this->expectException(StatusException::class);
        $collection->add($newerState);
        $collection->add($oldestState);
    }

    /**
     * @group UnitTest
     * @throws StatusException
     */
    public function test_should_trow_StatusException_given_new_state_time_bigger_than_now(): void
    {
        $collection = new StateCollection([
            StatusTest::createFakeStatus('open')
        ]);
        $tomorrow = new AppDateTime('+1 Day');
        $insaneState = Status::build('close', $tomorrow);

        $this->expectException(StatusException::class);
        $collection->add($insaneState);
    }

    /**
     * @group UnitTest
     * @throws StatusException
     */
    public function test_toArray_should_return_(): void
    {
        $collection = new StateCollection([
            StatusTest::createFakeStatus('open')
        ]);
        $array = $collection->toArray();
        foreach ($array as $value)
        {
            $this->assertIsArray($value);
            $this->assertArrayHasKey('status', $value);
            $this->assertArrayHasKey('updated_at', $value);
            $this->assertCount(2, $value);

        }
    }
}