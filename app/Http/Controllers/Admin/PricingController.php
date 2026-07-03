<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingRule;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function index()
    {
        $rules = PricingRule::orderByDesc('start_date')->get();
        return view('admin.pricing.index', compact('rules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'type'       => 'required|in:percentage,fixed',
            'adjustment' => 'required|integer',
            'min_nights' => 'nullable|integer|min:1',
            'active'     => 'boolean',
        ]);

        PricingRule::create($validated);

        return back()->with('success', 'Règle tarifaire créée.');
    }

    public function destroy(PricingRule $pricingRule)
    {
        $pricingRule->delete();
        return back()->with('success', 'Règle supprimée.');
    }

    public function toggle(PricingRule $pricingRule)
    {
        $pricingRule->update(['active' => ! $pricingRule->active]);
        return back()->with('success', 'Règle mise à jour.');
    }
}
