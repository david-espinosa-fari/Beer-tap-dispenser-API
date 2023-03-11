<?php

namespace Tests\Dispenser\Infrastructure\Responses;

use App\Dispenser\Infrastructure\Responses\DispenserWithOutStateResponse;
use PHPUnit\Framework\TestCase;
use Tests\Dispenser\Domain\DispenserTest;

class DispenserWithOutStateResponseTest extends TestCase
{

    /**
     * @group UnitTest
     */
    public function testSetup(): DispenserWithOutStateResponse
    {
        $formatResponse = new DispenserWithOutStateResponse();
        $this->assertInstanceOf(DispenserWithOutStateResponse::class, $formatResponse);

        return $formatResponse;
    }

    /**
     * @depends testSetup
     * @group UnitTest
     */
    public function test_on_invoke_should_only_return_id_and_flow(DispenserWithOutStateResponse $formatResponse): void
    {
        $response = $formatResponse(DispenserTest::createFakeDispenser());
        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('flow_volume', $response);
        $this->assertCount(2, $response);

        $this->assertFalse(isset($response['states']));
    }

}