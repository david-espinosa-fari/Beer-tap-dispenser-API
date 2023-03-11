<?php

namespace Tests\Dispenser\Infrastructure\Fakes;

use App\Shared\Cache\Apc\Domain\Contracts\IApcService;
use App\Shared\HttpCodes\HttpCodes;
use Exception;


class FakeThrowApcService implements IApcService
{


    public function delete($key): void
    {
        // TODO: Implement delete() method.
    }

    public function save(string $key, string $jsonEncoded, $ttl = 0): void
    {
        throw new Exception('Could not save value on apc, try again later', HttpCodes::SERVER_SIDE_ERROR);
    }

    public function findById(string $key): string
    {
        // TODO: Implement findById() method.
    }
}