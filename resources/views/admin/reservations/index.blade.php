@extends('layouts.admin')
@section('page-title', 'Réservations')

@section('content')

{{-- Filtres --}}
<div class="bg-white rounded-xl border p-4 mb-5 shadow-sm" style="border-color: var(--color-border);">
    <form action="{{ route('admin.reservations.index') }}" method="GET" class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, référence, email..." class="form-input text-sm col-span-2 sm:col-span-1">
        <select name="status" class="form-input text-sm cursor-pointer" onchange="this.form.submit()">
            <option value="">Tous statuts</option>
            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmées</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Annulées</option>
            <option value="modified" {{ request('status') === 'modified' ? 'selected' : '' }}>Modifiées</option>
        </select>
        <input type="date" name="date" value="{{ request('date') }}" class="form-input text-sm" onchange="this.form.submit()">
        <div class="flex gap-2">
            <button type="submit" class="btn-primary text-sm flex-1">Filtrer</button>
            <a href="{{ route('admin.reservations.index') }}" class="btn-outline text-sm px-3" aria-label="Réinitialiser les filtres">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </a>
        </div>
    </form>
</div>

{{-- Actions --}}
<div class="flex items-center justify-between mb-4">
    <p class="text-sm" style="color: var(--color-slate);">{{ $reservations->total() }} réservation(s)</p>
    <a href="{{ route('admin.reservations.create') }}" class="btn-primary text-sm py-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nouvelle réservation manuelle
    </a>
</div>

{{-- Table --}}
<div class="bg-white rounded-xl border shadow-sm overflow-hidden" style="border-color: var(--color-border);">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr style="background-color: var(--color-snow); border-bottom: 1px solid var(--color-border);">
                    <th class="px-4 py-3 text-left font-medium text-xs uppercase tracking-wide" style="color: var(--color-slate);">Référence</th>
                    <th class="px-4 py-3 text-left font-medium text-xs uppercase tracking-wide" style="color: var(--color-slate);">Client</th>
                    <th class="px-4 py-3 text-left font-medium text-xs uppercase tracking-wide hidden md:table-cell" style="color: var(--color-slate);">Chambre</th>
                    <th class="px-4 py-3 text-left font-medium text-xs uppercase tracking-wide hidden lg:table-cell" style="color: var(--color-slate);">Dates</th>
                    <th class="px-4 py-3 text-right font-medium text-xs uppercase tracking-wide hidden sm:table-cell" style="color: var(--color-slate);">Montant</th>
                    <th class="px-4 py-3 text-center font-medium text-xs uppercase tracking-wide" style="color: var(--color-slate);">Statut</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($reservations as $r)
                <tr class="hover:bg-slate-50 transition-colors cursor-pointer"
                    onclick="window.location='{{ route('admin.reservations.show', $r) }}'">
                    <td class="px-4 py-3 font-mono font-semibold text-xs tabular-nums" style="color: var(--color-orange);">{{ $r->ref }}</td>
                    <td class="px-4 py-3">
                        <p class="font-medium" style="color: var(--color-navy);">{{ $r->guest_name }}</p>
                        <p class="text-xs" style="color: var(--color-slate);">{{ $r->guest_phone }}</p>
                    </td>
                    <td class="px-4 py-3 hidden md:table-cell" style="color: var(--color-slate);">{{ $r->room->name }}</td>
                    <td class="px-4 py-3 hidden lg:table-cell text-xs tabular-nums" style="color: var(--color-slate);">
                        {{ $r->check_in->format('d/m/Y') }} → {{ $r->check_out->format('d/m/Y') }}
                        <span class="block mt-0.5">{{ $r->nights }} nuit{{ $r->nights > 1 ? 's' : '' }}</span>
                    </td>
                    <td class="px-4 py-3 text-right font-bold hidden sm:table-cell tabular-nums" style="color: var(--color-navy);">
                        {{ number_format($r->total_price, 0, ',', ' ') }} <span class="text-xs font-normal" style="color: var(--color-slate);">FCFA</span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold whitespace-nowrap
                            {{ $r->status === 'confirmed' ? 'bg-green-100 text-green-700' : ($r->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ $r->status_label }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.reservations.show', $r) }}" class="inline-flex items-center gap-1 text-xs font-medium hover:underline" style="color: var(--color-blue);" onclick="event.stopPropagation()">
                            Voir
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-12 text-center text-sm" style="color: var(--color-slate);">Aucune réservation trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">{{ $reservations->links() }}</div>

@endsection
