{{-- Zone d'upload de photos : clic ou glisser-déposer, sélections cumulables,
     prévisualisation et retrait avant envoi. Soumet new_images[] (lu par le contrôleur). --}}
<div>
    <label class="form-label">{{ $label ?? 'Photos de la chambre' }}</label>
    <div x-data="imageUpload()">
        <input type="file" name="new_images[]" multiple accept="image/*" class="hidden" x-ref="input" @change="pick()">

        <div role="button" tabindex="0"
             @click="$refs.input.click()"
             @keydown.enter.prevent="$refs.input.click()"
             @dragover.prevent="dragging = true"
             @dragleave.prevent="dragging = false"
             @drop.prevent="drop($event)"
             class="rounded-xl border-2 border-dashed p-6 text-center cursor-pointer transition-colors"
             :class="dragging ? 'bg-orange-50' : 'hover:bg-slate-50'"
             :style="dragging ? 'border-color: var(--color-orange);' : 'border-color: var(--color-border);'">
            <svg class="w-8 h-8 mx-auto mb-2" style="color: var(--color-orange);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <p class="text-sm font-semibold" style="color: var(--color-navy);">Cliquez ou glissez-déposez vos photos</p>
            <p class="text-xs mt-1" style="color: var(--color-slate);">JPG, PNG — 2 Mo max par image. Vous pouvez en ajouter en plusieurs fois.</p>
        </div>

        {{-- Prévisualisations --}}
        <div class="flex flex-wrap gap-3 mt-3" x-show="files.length" style="display: none;">
            <template x-for="(item, i) in files" :key="item.url">
                <div class="relative group">
                    <img :src="item.url" :alt="item.file.name" class="w-24 h-24 object-cover rounded-lg border" style="border-color: var(--color-border);">
                    <button type="button" @click="remove(i)" :aria-label="'Retirer ' + item.file.name"
                            class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-white border shadow flex items-center justify-center cursor-pointer transition-colors hover:bg-red-50 hover:text-red-600"
                            style="border-color: var(--color-border); color: var(--color-slate);">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    <p class="mt-1 text-[10px] truncate w-24 text-center" style="color: var(--color-slate);" x-text="item.file.name"></p>
                </div>
            </template>
        </div>
        <p class="text-xs mt-2" x-show="files.length" style="color: var(--color-slate); display: none;">
            <span x-text="files.length"></span> photo(s) prête(s) à être envoyée(s) — elles seront enregistrées avec le formulaire.
        </p>
    </div>
</div>

@once
@push('scripts')
<script>
function imageUpload() {
    return {
        files: [],
        dragging: false,
        pick() {
            this.addAll(this.$refs.input.files);
        },
        drop(event) {
            this.dragging = false;
            this.addAll(Array.from(event.dataTransfer.files).filter(f => f.type.startsWith('image/')));
        },
        addAll(list) {
            for (const file of Array.from(list)) {
                if (!this.files.some(x => x.file.name === file.name && x.file.size === file.size)) {
                    this.files.push({ file, url: URL.createObjectURL(file) });
                }
            }
            this.rebuild();
        },
        remove(index) {
            URL.revokeObjectURL(this.files[index].url);
            this.files.splice(index, 1);
            this.rebuild();
        },
        // Le champ file natif remplace la sélection à chaque ouverture :
        // on reconstruit sa liste depuis le cumul pour permettre l'ajout en plusieurs fois.
        rebuild() {
            const dt = new DataTransfer();
            this.files.forEach(x => dt.items.add(x.file));
            this.$refs.input.files = dt.files;
        },
    };
}
</script>
@endpush
@endonce
