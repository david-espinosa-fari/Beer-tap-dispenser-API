<?php

namespace App\Dispenser\Domain;

use App\Shared\DateTime\AppDateTime;

class Spent
{
    private const COST_BEAR_BY_LITRES = 12.25;
    private $totalAmount;
    private $usages;
    private Dispenser $dispenser;
    public function __construct(Dispenser $dispenser)
    {
        $this->dispenser = $dispenser;

        $states = $dispenser->getStatesCollections();
        $statesCount = $states->count();

        for ($i = 0; $i < $statesCount; $i++) {
            assert(true === ($states[$i] instanceof Status));

            if (isset($states[$i + 1]) && $states[$i]->isOpen())
            {
                $this->usages[] = [
                    'opened_at' => (string)$states[$i]->whenUpdated(),
                    'closed_at' => (string)$states[$i + 1]->whenUpdated(),
                    'flow_volume' => $dispenser->getFlowVolume()->value(),
                    'total_spent' => $this->spentCurrentUsage($states[$i]->whenUpdated(), $states[$i + 1]->whenUpdated())
                ];
            }elseif ($states[$i]->isOpen())
            {
                $this->usages[] = [
                    'opened_at' => (string)$states[$i]->whenUpdated(),
                    'closed_at' => null,
                    'flow_volume' => $dispenser->getFlowVolume()->value(),
                    'total_spent' => $this->spentCurrentUsage($states[$i]->whenUpdated(), new AppDateTime())
                ];
            }
        }
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->totalAmount,
            'usages' => $this->usages
        ];
    }

    private function spentCurrentUsage(AppDateTime $openTime, AppDateTime $closedTime): float
    {
        $diff = $closedTime->getTimestamp() - $openTime->getTimestamp();

        $currentUsageSpent = $this->dispenser->getFlowVolume()->value() * $diff * self::COST_BEAR_BY_LITRES;

        $this->increaseTotalAmount($currentUsageSpent);
        return $currentUsageSpent;
    }

    private function increaseTotalAmount(float $currentUsageSpent): void
    {
        $this->totalAmount += $currentUsageSpent;
    }

}