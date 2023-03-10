<?php
namespace App\Shared\Cache\Apc\Domain\Contracts;

interface IApcService
{
    public function delete($key): void;

    public function save(string $key, string $jsonEncoded, $ttl = 0): void;

    public function findById(string $key): string;
}