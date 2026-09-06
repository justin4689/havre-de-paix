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
     * Prix total du séjour, nuit par nuit selon la grille « Tarifs Assinie » :
     * saison (haute : déc–mars & juil–août) × type de nuit (semaine / week-end
     * vendredi-samedi). Une règle tarifaire admin active couvrant tout le
     * séjour s'applique ensuite (promotion ou majoration exceptionnelle).
     */
    public function priceForStay(Room $room, string $checkIn, string $checkOut): int
    {
        $total = 0;
        $night = new \DateTimeImmutable($checkIn);
        $end   = new \DateTimeImmutable($checkOut);

        while ($night < $end) {
            $total += $this->nightlyRate($room, $night);
            $night = $night->modify('+1 day');
        }

        $rule = $this->pricingRules->activeRuleCovering($checkIn, $checkOut);

        if (! $rule) {
            return $total;
        }

        return $rule->type === 'percentage'
            ? (int) round($total * (1 + $rule->adjustment / 100))
            : $total + ($rule->adjustment * $this->nightsBetween($checkIn, $checkOut));
    }

    /** Tarif d'une nuit donnée ; repli sur +10 % (week-end) si la grille est incomplète. */
    public function nightlyRate(Room $room, \DateTimeImmutable $night): int
    {
        $high    = $this->isHighSeason($night);
        $weekend = in_array((int) $night->format('N'), config('hotel.weekend_nights', [5, 6]), true);

        $lowBase  = (int) $room->price_per_night;
        $highBase = (int) ($room->price_high_season ?? $lowBase);

        return match (true) {
            $high && $weekend => (int) ($room->price_weekend_high ?? round($highBase * 1.10)),
            $weekend          => (int) ($room->price_weekend_low ?? round($lowBase * 1.10)),
            $high             => $highBase,
            default           => $lowBase,
        };
    }

    /** Haute saison : plages mois-jour récurrentes (config hotel), bornes incluses. */
    public function isHighSeason(\DateTimeImmutable $date): bool
    {
        $md = $date->format('m-d');

        foreach (config('hotel.high_season_ranges', []) as [$start, $end]) {
            $inRange = $start <= $end
                ? ($md >= $start && $md <= $end)
                : ($md >= $start || $md <= $end); // plage chevauchant le 1er janvier

            if ($inRange) {
                return true;
            }
        }

        return false;
    }
}
