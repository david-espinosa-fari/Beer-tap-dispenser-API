<?php
namespace App\Dispenser\Domain;

use App\Dispenser\Domain\Exceptions\StatusException;
use App\Dispenser\Domain\ValueObjects\FlowVolume;
use App\Shared\Uuid\UuidGenerator;

class Dispenser
{

    private UuidGenerator $id;
    private FlowVolume $flow_volume;
    private StateCollection $stateCollection;

    public function __construct(UuidGenerator $id, FlowVolume $flow_volume, StateCollection $stateCollection)
    {
        $this->id = $id;
        $this->flow_volume = $flow_volume;
        $this->stateCollection = $stateCollection;
    }

    public static function build(string $id, float $flow_volume, array $status): Dispenser
    {
        return new self(new UuidGenerator($id), new FlowVolume($flow_volume), new StateCollection($status));
    }

    public function toArray(): array
    {
        return [
            'id' => (string)$this->id,
            'flow_volume' => $this->flow_volume->value(),
            'states' => $this->stateCollection->toArray()
        ];
    }

    public function __toString(): string
    {
        return (string)$this->id;
    }

    /**
     * @throws StatusException
     */
    public function addNewStatus(Status $status): void
    {
        $this->stateCollection->add($status);
    }

    public function getStatesCollections(): StateCollection
    {
        return $this->stateCollection;
    }

    public function getFlowVolume(): FlowVolume
    {
        return $this->flow_volume;
    }

}