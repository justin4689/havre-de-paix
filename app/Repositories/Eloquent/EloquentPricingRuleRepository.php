<?php

namespace App\Repositories\Eloquent;

use App\Models\PricingRule;
use App\Repositories\Contracts\PricingRuleRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentPricingRuleRepository implements PricingRuleRepositoryInterface
{
    public function allOrdered(): Collection
    {
        return PricingRule::orderByDesc('start_date')->get();
    }

    public function activeRuleCovering(string $checkIn, string $checkOut): ?PricingRule
    {
        return PricingRule::where('active', true)
            ->where('start_date', '<=', $checkIn)
            ->where('end_date', '>=', $checkOut)
            ->orderByDesc('adjustment')
            ->first();
    }

    public function create(array $attributes): PricingRule
    {
        return PricingRule::create($attributes);
    }

    public function delete(PricingRule $rule): void
    {
        $rule->delete();
    }

    public function toggle(PricingRule $rule): PricingRule
    {
        $rule->update(['active' => ! $rule->active]);

        return $rule;
    }
}
