<?php

namespace App\Services;

use App\Models\PricingRule;
use App\Repositories\Contracts\PricingRuleRepositoryInterface;
use Illuminate\Support\Collection;

class PricingRuleService
{
    public function __construct(
        private readonly PricingRuleRepositoryInterface $pricingRules,
    ) {}

    public function all(): Collection
    {
        return $this->pricingRules->allOrdered();
    }

    public function create(array $validated): PricingRule
    {
        return $this->pricingRules->create($validated);
    }

    public function delete(PricingRule $rule): void
    {
        $this->pricingRules->delete($rule);
    }

    public function toggle(PricingRule $rule): PricingRule
    {
        return $this->pricingRules->toggle($rule);
    }
}
