<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PricingRuleRequest;
use App\Models\PricingRule;
use App\Services\PricingRuleService;

class PricingController extends Controller
{
    public function __construct(
        private readonly PricingRuleService $pricingRuleService,
    ) {}

    public function index()
    {
        $rules = $this->pricingRuleService->all();

        return view('admin.pricing.index', compact('rules'));
    }

    public function store(PricingRuleRequest $request)
    {
        $this->pricingRuleService->create($request->validated());

        return back()->with('success', 'Règle tarifaire créée.');
    }

    public function destroy(PricingRule $pricingRule)
    {
        $this->pricingRuleService->delete($pricingRule);

        return back()->with('success', 'Règle supprimée.');
    }

    public function toggle(PricingRule $pricingRule)
    {
        $this->pricingRuleService->toggle($pricingRule);

        return back()->with('success', 'Règle mise à jour.');
    }
}
