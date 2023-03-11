<?php

namespace App\Dispenser\Domain;

use App\Dispenser\Domain\Exceptions\StatusException;
use App\Shared\DateTime\AppDateTime;
use App\Shared\HttpCodes\HttpCodes;
use ArrayObject;

class StateCollection extends ArrayObject
{
    public function __construct(array $status)
    {
        foreach ($status as $key => $state) {
            if (!$state instanceof Status) {
                throw new StatusException('This is a Collection of Status. Only instance of Status are allowed.', HttpCodes::BAD_REQUEST);
            }
        }

        parent::__construct($status);
    }
    public function toArray(): array
    {
        $tmp = [];
        foreach ($this->getArrayCopy() as $key => $status) {
            assert(true === $status instanceof Status);
            $tmp[] = $status->toArray();
        }
        return $tmp;
    }

    /**
     * @throws StatusException
     */
    public function add(Status $newStatus): void
    {
        $lastStoredState = $this->lastElement();

        $this->statesAreEquals($newStatus, $lastStoredState);
        $this->haveSenceNewDatetime($newStatus, $lastStoredState);

        $this->append($newStatus);
    }
    private function statesAreEquals(Status $newStatus,Status $lastStoredState): void
    {
        if ((string)$lastStoredState === (string)$newStatus)
        {
            throw new StatusException('Dispenser is already '.$lastStoredState, HttpCodes::CONFLICT);
        }
    }
    private function haveSenceNewDatetime(Status $newStatus,Status $lastStoredState): void
    {
        if (($newStatus->whenUpdated()->getTimestamp() - $lastStoredState->whenUpdated()->getTimestamp()) < 0)
        {
            throw new StatusException('The new date time should be greater than the previews state', HttpCodes::BAD_REQUEST);
        }
        if ($newStatus->whenUpdated() > new AppDateTime('now'))
        {
            throw new StatusException('You are entering a date that has not yet occurred.', HttpCodes::BAD_REQUEST);
        }
    }
    private function lastElement(): Status
    {
        return $this->offsetGet($this->count()-1);
    }

}