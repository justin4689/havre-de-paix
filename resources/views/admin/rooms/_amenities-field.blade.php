{{-- Champ équipements : ajout un par un, icône détectée en direct.
     Attend $amenities (array) — soumet amenities[] conforme à la validation. --}}
<div>
    <label for="amenity-draft" class="form-label">Équipements</label>
    <div x-data="amenityTags(@js(array_values($amenities)), @js(\App\Support\AmenityIcon::KEYWORDS), @js(\App\Support\AmenityIcon::PATHS))">

        {{-- Valeurs soumises --}}
        <template x-for="(item, i) in items" :key="'field-' + i">
            <input type="hidden" name="amenities[]" :value="item">
        </template>

        {{-- Saisie avec icône détectée en direct --}}
        <div class="flex gap-2">
            <div class="relative flex-1">
                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none transition-all"
                     style="color: var(--color-orange);"
                     fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                     viewBox="0 0 24 24" aria-hidden="true"><path :d="iconPath(draft)"/></svg>
                <input type="text" id="amenity-draft" x-model="draft"
                       @keydown.enter.prevent="add()"
                       placeholder="Ex : WiFi haut débit, Climatisation, Jacuzzi..."
                       class="form-input pl-10 text-sm" autocomplete="off">
            </div>
            <button type="button" @click="add()" class="btn-outline text-sm px-4 py-2">Ajouter</button>
        </div>
        <p class="text-xs mt-1.5" style="color: var(--color-slate);">Entrée ou « Ajouter » pour valider — l'icône est détectée automatiquement.</p>

        {{-- Puces --}}
        <div class="flex flex-wrap gap-2 mt-3" x-show="items.length" style="display: none;">
            <template x-for="(item, i) in items" :key="item">
                <span class="inline-flex items-center gap-1.5 pl-2.5 pr-1 py-1 rounded-full text-xs font-medium border bg-white"
                      style="border-color: var(--color-border); color: var(--color-navy);">
                    <svg class="w-3.5 h-3.5 shrink-0" style="color: var(--color-orange);"
                         fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                         viewBox="0 0 24 24" aria-hidden="true"><path :d="iconPath(item)"/></svg>
                    <span x-text="item"></span>
                    <button type="button" @click="remove(i)" aria-label="Retirer l'équipement"
                            class="w-5 h-5 rounded-full flex items-center justify-center cursor-pointer transition-colors hover:bg-red-50 hover:text-red-600"
                            style="color: var(--color-slate);">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </span>
            </template>
        </div>
        <p class="text-xs mt-2" x-show="!items.length" style="color: var(--color-slate); display: none;">Aucun équipement ajouté pour le moment.</p>
    </div>
</div>

@once
@push('scripts')
<script>
function amenityTags(initial, keywords, paths) {
    return {
        items: Array.isArray(initial) ? initial : [],
        draft: '',
        iconPath(name) {
            const n = (name || '').toLowerCase();
            if (n.trim()) {
                for (const [keyword, icon] of Object.entries(keywords)) {
                    if (n.includes(keyword)) return paths[icon];
                }
            }
            return paths.check;
        },
        add() {
            const value = this.draft.trim();
            if (!value) return;
            if (!this.items.some(i => i.toLowerCase() === value.toLowerCase())) {
                this.items.push(value);
            }
            this.draft = '';
        },
        remove(index) {
            this.items.splice(index, 1);
        },
    };
}
</script>
@endpush
@endonce
