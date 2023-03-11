<?php

namespace Tests\Shared\DateTime;

use App\Shared\DateTime\AppDateTime;
use PHPUnit\Framework\TestCase;

class AppDateTimeTest extends TestCase
{

    /**
     * @group UnitTest
     * @group AppDateTime
     */
    public function testSetup(): AppDateTime
    {
        $dateTime = new AppDateTime();
        $this->assertInstanceOf(AppDateTime::class, $dateTime);
        return $dateTime;
    }

    /**
     * @depends testSetup
     * @group UnitTest
     */
    public function test_TimeZone_should_be_Europe_Madrid_by_default(AppDateTime $dateTime): void
    {
        $this->assertEquals('Europe/Madrid', $dateTime->getTimezone()->getName());
    }

}