@extends('layouts.admin')
@section('page-title', 'Tableau de bord')

@section('content')

{{-- KPIs --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach ([
        ['label' => 'Arrivées aujourd\'hui', 'value' => $arrivals->count(), 'icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z', 'color' => 'var(--color-orange)'],
        ['label' => 'Taux d\'occupation', 'value' => $occupancy . '%', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'color' => 'var(--color-blue)'],
        ['label' => 'Revenus du mois', 'value' => number_format($monthRevenue, 0, ',', ' ') . ' FCFA', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => '#16a34a'],
        ['label' => 'Réservations à venir', 'value' => $pending, 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'color' => '#7c3aed'],
    ] as $kpi)
    <div class="bg-white rounded-xl p-5 border shadow-sm" style="border-color: var(--color-border);">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-medium uppercase tracking-wide" style="color: var(--color-slate);">{{ $kpi['label'] }}</p>
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background-color: {{ $kpi['color'] }}20;">
                <svg class="w-4 h-4" style="color: {{ $kpi['color'] }};" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $kpi['icon'] }}"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold" style="color: var(--color-navy);">{{ $kpi['value'] }}</p>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Arrivées du jour --}}
    <div class="bg-white rounded-xl border shadow-sm" style="border-color: var(--color-border);">
        <div class="px-5 py-4 border-b flex items-center justify-between" style="border-color: var(--color-border);">
            <h2 class="font-semibold" style="color: var(--color-navy);">Arrivées aujourd'hui ({{ now()->format('d/m/Y') }})</h2>
            <span class="text-xs px-2 py-1 rounded-full font-semibold" style="background-color: var(--color-sand); color: #9a3412;">{{ $arrivals->count() }}</span>
        </div>
        <div class="divide-y" style="--tw-divide-color: var(--color-border);">
            @forelse ($arrivals as $r)
            <div class="px-5 py-3 flex items-center justify-between">
                <div>
                    <p class="font-medium text-sm" style="color: var(--color-navy);">{{ $r->guest_name }}</p>
                    <p class="text-xs" style="color: var(--color-slate);">{{ $r->room->name }} · {{ $r->guests }} pers.</p>
                </div>
                <a href="{{ route('admin.reservations.show', $r) }}" class="text-xs px-2 py-1 rounded-lg transition-colors" style="color: var(--color-blue); background-color: var(--color-sky);">Détails</a>
            </div>
            @empty
            <div class="px-5 py-8 text-center text-sm" style="color: var(--color-slate);">Aucune arrivée prévue aujourd'hui</div>
            @endforelse
        </div>
    </div>

    {{-- Dernières réservations --}}
    <div class="bg-white rounded-xl border shadow-sm" style="border-color: var(--color-border);">
        <div class="px-5 py-4 border-b flex items-center justify-between" style="border-color: var(--color-border);">
            <h2 class="font-semibold" style="color: var(--color-navy);">Dernières réservations</h2>
            <a href="{{ route('admin.reservations.index') }}" class="text-xs" style="color: var(--color-blue);">Voir tout →</a>
        </div>
        <div class="divide-y">
            @forelse ($recent as $r)
            <div class="px-5 py-3 flex items-center gap-3">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="text-xs font-mono font-semibold" style="color: var(--color-orange);">{{ $r->ref }}</span>
                        <span class="text-xs px-1.5 py-0.5 rounded font-medium
                            {{ $r->status === 'confirmed' ? 'bg-green-100 text-green-700' : ($r->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ $r->status_label }}
                        </span>
                    </div>
                    <p class="text-sm font-medium truncate" style="color: var(--color-navy);">{{ $r->guest_name }}</p>
                    <p class="text-xs" style="color: var(--color-slate);">{{ $r->room->name }} · {{ $r->check_in->format('d/m') }} → {{ $r->check_out->format('d/m/Y') }}</p>
                </div>
                <p class="text-sm font-semibold shrink-0" style="color: var(--color-orange);">{{ number_format($r->total_price, 0, ',', ' ') }}<span class="text-xs font-normal" style="color: var(--color-slate);"> FCFA</span></p>
            </div>
            @empty
            <div class="px-5 py-8 text-center text-sm" style="color: var(--color-slate);">Aucune réservation</div>
            @endforelse
        </div>
    </div>
</div>

@endsection
