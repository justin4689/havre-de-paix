@extends('layouts.admin')
@section('page-title', 'Nouvelle réservation manuelle')

@section('content')

<div class="mb-5">
    <a href="{{ route('admin.reservations.index') }}" class="text-sm flex items-center gap-1" style="color: var(--color-blue);">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Retour
    </a>
</div>

<div>
    <div class="bg-white rounded-xl border shadow-sm p-6" style="border-color: var(--color-border);">
        <h2 class="text-lg font-semibold mb-6" style="color: var(--color-navy);">Créer une réservation</h2>

        @if ($errors->any())
        <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
            <ul class="space-y-1 list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.reservations.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="room-search" class="form-label">Chambre <span class="text-red-500">*</span></label>
                    <div x-data="roomSelect({{ $rooms->map(fn ($r) => ['id' => $r->id, 'label' => $r->name . ' — ' . number_format($r->price_per_night, 0, ',', ' ') . ' FCFA/nuit'])->values()->toJson() }}, '{{ old('room_id') }}')"
                         class="relative" @click.outside="open = false">
                        <input type="hidden" name="room_id" :value="selected ? selected.id : ''">
                        <div class="relative">
                            <input type="text" id="room-search" x-model="search"
                                   @focus="open = true; search = ''"
                                   @input="highlighted = 0; open = true"
                                   @keydown.arrow-down.prevent="move(1)"
                                   @keydown.arrow-up.prevent="move(-1)"
                                   @keydown.enter.prevent="choose(highlighted)"
                                   @keydown.escape="open = false"
                                   :placeholder="selected ? selected.label : 'Rechercher une chambre...'"
                                   :required="!selected"
                                   class="form-input pr-9 cursor-pointer"
                                   role="combobox" :aria-expanded="open" autocomplete="off">
                            <svg class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none transition-transform duration-200"
                                 :class="open ? 'rotate-180' : ''"
                                 style="color: var(--color-slate);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <div x-show="open" x-transition.opacity.duration.150ms style="display: none;"
                             class="absolute z-20 mt-1 w-full bg-white border rounded-xl shadow-lg max-h-56 overflow-y-auto"
                             :style="'border-color: var(--color-border);'">
                            <template x-for="(room, i) in filtered" :key="room.id">
                                <button type="button" @click="choose(i)" @mouseenter="highlighted = i"
                                        class="w-full text-left px-4 py-2.5 text-sm cursor-pointer transition-colors"
                                        :class="highlighted === i ? 'bg-orange-50' : ''"
                                        :style="selected && selected.id === room.id ? 'color: var(--color-orange); font-weight: 600;' : 'color: var(--color-navy);'"
                                        x-text="room.label"></button>
                            </template>
                            <p x-show="filtered.length === 0" class="px-4 py-3 text-sm" style="color: var(--color-slate);">Aucune chambre trouvée</p>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="form-label">Nb de voyageurs <span class="text-red-500">*</span></label>
                    <input type="number" name="guests" value="{{ old('guests', 1) }}" min="1" max="10" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Arrivée <span class="text-red-500">*</span></label>
                    <input type="date" name="check_in" value="{{ old('check_in') }}" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Départ <span class="text-red-500">*</span></label>
                    <input type="date" name="check_out" value="{{ old('check_out') }}" class="form-input" required>
                </div>
            </div>

            <hr style="border-color: var(--color-border);">
            <h3 class="font-medium text-sm" style="color: var(--color-navy);">Informations client</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="sm:col-span-2 lg:col-span-1">
                    <label class="form-label">Nom complet <span class="text-red-500">*</span></label>
                    <input type="text" name="guest_name" value="{{ old('guest_name') }}" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="guest_email" value="{{ old('guest_email') }}" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Téléphone <span class="text-red-500">*</span></label>
                    <input type="tel" name="guest_phone" value="{{ old('guest_phone') }}" class="form-input" required>
                </div>
                <div class="sm:col-span-2 lg:col-span-3">
                    <label class="form-label">Demandes spéciales</label>
                    <textarea name="special_requests" rows="3" class="form-input resize-none">{{ old('special_requests') }}</textarea>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Créer la réservation</button>
                <a href="{{ route('admin.reservations.index') }}" class="btn-outline">Annuler</a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function roomSelect(rooms, oldId) {
    return {
        rooms,
        search: '',
        open: false,
        highlighted: 0,
        selected: null,
        init() {
            if (oldId) {
                this.selected = this.rooms.find(r => String(r.id) === String(oldId)) ?? null;
            }
        },
        get filtered() {
            const q = this.search.toLowerCase().trim();
            return q ? this.rooms.filter(r => r.label.toLowerCase().includes(q)) : this.rooms;
        },
        move(step) {
            this.open = true;
            const n = this.filtered.length;
            if (!n) return;
            this.highlighted = (this.highlighted + step + n) % n;
        },
        choose(i) {
            const room = this.filtered[i];
            if (!room) return;
            this.selected = room;
            this.search = '';
            this.open = false;
            this.highlighted = 0;
        },
    };
}
</script>
@endpush
