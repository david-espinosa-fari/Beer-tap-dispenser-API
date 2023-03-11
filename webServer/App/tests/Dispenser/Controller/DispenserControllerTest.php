<?php

namespace Tests\Dispenser\Controller;

use App\Shared\HttpCodes\HttpCodes;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DispenserControllerTest extends WebTestCase
{
    private static string $currentUuid;
    /**
     * @throws JsonException
     */
    public function test_expect_create_dispenser_response_to_have_keys(): void
    {
        $client = static::createClient();
        $client->request('POST', '/dispenser',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ],[],[], json_encode(['flow_volume' => 0.0653], JSON_THROW_ON_ERROR),
        );

        $content = $client->getResponse()->getContent();
        $this->assertResponseStatusCodeSame(HttpCodes::SUCCESS);

        $this->assertIsString($content);

        $decodedResponse = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        $this->assertIsArray($decodedResponse);

        $this->assertArrayHasKey('id', $decodedResponse);
        $this->assertArrayHasKey('flow_volume', $decodedResponse);
        $this->assertCount(2, $decodedResponse);
        self::$currentUuid = $decodedResponse['id'];
    }
    public function test_expect_update_dispenser_status_response_to_have_keys(): void
    {
        $client = static::createClient();
        $client->request('PUT', '/dispenser/'.self::$currentUuid.'/status',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ],[],[], json_encode([
                'status' => 'open',
                'updated_at' => null
            ], JSON_THROW_ON_ERROR),
        );

        $content = $client->getResponse()->getContent();
        $this->assertResponseStatusCodeSame(HttpCodes::ACCEPTED);

        $this->assertIsString($content);

        $decodedResponse = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        $this->assertIsArray($decodedResponse);

        $this->assertArrayHasKey('status', $decodedResponse);
        $this->assertArrayHasKey('updated_at', $decodedResponse);
        $this->assertCount(2, $decodedResponse);
    }
    public function test_expect_spending_response_to_have_keys(): void
    {
        $client = static::createClient();
        $client->request('GET', '/dispenser/'.self::$currentUuid.'/spending');

        $content = $client->getResponse()->getContent();
        $this->assertResponseStatusCodeSame(HttpCodes::SUCCESS);

        $decodedResponse = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        $this->assertIsArray($decodedResponse);
        $this->assertArrayHasKey('amount', $decodedResponse);
        $this->assertArrayHasKey('usages', $decodedResponse);
        $this->assertCount(2, $decodedResponse);
    }
}