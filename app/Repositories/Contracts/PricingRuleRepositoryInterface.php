<?php

namespace App\Repositories\Contracts;

use App\Models\PricingRule;
use Illuminate\Support\Collection;

interface PricingRuleRepositoryInterface
{
    public function allOrdered(): Collection;

    public function activeRuleCovering(string $checkIn, string $checkOut): ?PricingRule;

    public function create(array $attributes): PricingRule;

    public function delete(PricingRule $rule): void;

    public function toggle(PricingRule $rule): PricingRule;
}
