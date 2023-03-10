<?php

namespace App\Shared\Apc\Infrastructure;


use App\Shared\Cache\Apc\Infrastructure\Apc;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ApcTest extends KernelTestCase
{
    protected const FAKE_TEMPORAL_KEY = 'fake';
    /**
     * @group Apc
     * @group   Integration
     */
    public function testSetup(): Apc
    {
        self::bootKernel();
        $container = self::$kernel->getContainer();

        $apc = $container->get(Apc::class);
        $this->assertInstanceOf(Apc::class, $apc);
        return $apc;
    }

    /**
     * @depends testSetup
     * @group Integration
     * @param Apc $apc
     * @throws Exception
     */
    public function test_should_trow_exception_on_failed_delete(Apc $apc): void
    {
        $this->expectException(Exception::class);
        $apc->delete('unexistant key');
    }

    /**
     * @depends testSetup
     * @group Integration
     * @param Apc $apc
     * @throws Exception
     */
    public function test_should_return_void_on_successfully_delete(Apc $apc): void
    {
        $apc->save(self::FAKE_TEMPORAL_KEY, '{"asd":"123"}');
        $this->assertNull($apc->delete(self::FAKE_TEMPORAL_KEY));
    }

    /**
     * @depends testSetup
     * @group Integration
     * @param Apc $apc
     * @throws Exception
     */
    public function test_should_return_void_on_successfully_save(Apc $apc): void
    {
        $this->assertNull($apc->save(self::FAKE_TEMPORAL_KEY, '{"asd":"123"}'));
        $apc->delete(self::FAKE_TEMPORAL_KEY);
    }

    /**
     * @depends testSetup
     * @group Integration
     * @param Apc $apc
     * @throws Exception
     */
    public function test_should_return_string_when_findById(Apc $apc): void
    {
        $apc->save(self::FAKE_TEMPORAL_KEY, '{"asd":"123"}');

        $value = $apc->findById(self::FAKE_TEMPORAL_KEY);
        $this->assertIsString($value);
        $apc->delete(self::FAKE_TEMPORAL_KEY);
    }

    /**
     * @depends testSetup
     * @group Integration
     * @param Apc $apc
     * @throws Exception
     */
    public function test_should_throw_when_key_not_found(Apc $apc): void
    {
        $this->expectException(Exception::class);
        $value = $apc->findById('key-lerele');
    }
}