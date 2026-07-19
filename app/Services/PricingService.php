<?php

namespace App\Services;

use App\Models\Room;
use App\Repositories\Contracts\PricingRuleRepositoryInterface;

class PricingService
{
    public function __construct(
        private readonly PricingRuleRepositoryInterface $pricingRules,
    ) {}

    public function nightsBetween(string $checkIn, string $checkOut): int
    {
        return (int) (new \DateTime($checkOut))->diff(new \DateTime($checkIn))->days;
    }

    /**
     * Prix total du séjour : nuits × tarif, ajusté par la règle saisonnière
     * active couvrant tout le séjour (la plus forte en cas de chevauchement).
     */
    public function priceForStay(Room $room, string $checkIn, string $checkOut): int
    {
        $nights = $this->nightsBetween($checkIn, $checkOut);
        $base   = $room->price_per_night * $nights;

        $rule = $this->pricingRules->activeRuleCovering($checkIn, $checkOut);

        if (! $rule) {
            return $base;
        }

        return $rule->type === 'percentage'
            ? (int) round($base * (1 + $rule->adjustment / 100))
            : $base + ($rule->adjustment * $nights);
    }
}
