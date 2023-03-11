<?php

namespace App\Dispenser\Infrastructure\DispenserRepository;

use App\Dispenser\Domain\Contracts\IDispenserRepository;
use App\Dispenser\Domain\Dispenser;
use App\Dispenser\Domain\Exceptions\DispenserException;
use App\Dispenser\Domain\Exceptions\StatusException;
use App\Dispenser\Domain\Status;
use App\Shared\Cache\Apc\Domain\Contracts\IApcService;
use App\Shared\HttpCodes\HttpCodes;
use Throwable;

class ApcDispenserRepo implements IDispenserRepository
{

    /**
     * @var ApcDispenserRepo
     */
    private static $instance;
    /**
     * @var IApcService
     */
    private IApcService $apcService;
    /**
     * @var int
     */
    private int $ttl;

    public function __construct(IApcService $apcService, int $default_apc_ttl)
    {
        $this->apcService = $apcService;
        $this->ttl = $default_apc_ttl;
    }

    public static function getInstance(IApcService $apcService, int $ttl): ApcDispenserRepo
    {
        return self::$instance ?? self::$instance = new self($apcService, $ttl);
    }

    public function save(Dispenser $dispenser): void
    {
        try {
            $this->apcService->save(
                (string)$dispenser,
                json_encode($dispenser->toArray(), JSON_THROW_ON_ERROR),
                $this->ttl
            );
        } catch (Throwable $e) {
            throw new DispenserException('Unexpected API error', HttpCodes::SERVER_SIDE_ERROR);
        }
    }

    public function findById(string $dispenserId): Dispenser
    {
        try {
            $jsonDispenser = $this->apcService->findById($dispenserId);

            $content = json_decode($jsonDispenser, true, 512, JSON_THROW_ON_ERROR);
            $states = $this->createStates($content['states']);
            return Dispenser::build($content['id'], $content['flow_volume'], $states);
        } catch (Throwable $e) {
            throw new DispenserException('Requested dispenser does not exist', HttpCodes::NOT_FOUND);
        }
    }

    private function createStates(array $rawStatus): array
    {
        $tmp = [];
        foreach ($rawStatus as $key => $state) {
            $tmp[] = Status::build($state['status'], $state['updated_at']);
        }
        return $tmp;
    }
}