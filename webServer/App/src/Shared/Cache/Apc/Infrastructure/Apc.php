<?php
namespace App\Shared\Cache\Apc\Infrastructure;


use App\Shared\Cache\Apc\Domain\Contracts\IApcService;
use App\Shared\HttpCodes\HttpCodes;
use Exception;

class Apc implements IApcService
{
    public function delete($key): void
    {
        $result = apcu_delete($key);
        if ($result === false )
        {
            throw new Exception('Could not delete key on apc, try again later', HttpCodes::SERVER_SIDE_ERROR);
        }
    }

    public function save(string $key, string $jsonEncoded, $ttl = 5): void
    {
        apcu_store($key, $jsonEncoded, $ttl);
    }

    public function findById(string $key): string
    {
        $result = apcu_fetch($key, $success);
        if ($result === false )
        {
            throw new Exception('Key not found', HttpCodes::NOT_FOUND);
        }
        return $result;
    }
}