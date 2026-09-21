<?php

namespace App\Services;

use App\Models\Room;
use App\Repositories\Contracts\RoomRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RoomAdminService
{
    public function __construct(
        private readonly RoomRepositoryInterface $rooms,
    ) {}

    public function all(): Collection
    {
        return $this->rooms->allOrderedByPrice();
    }

    public function activeForSelect(): Collection
    {
        return $this->rooms->activeOrderedByName();
    }

    /** @param UploadedFile[] $newImages */
    public function create(array $validated, array $newImages = []): Room
    {
        $validated['slug'] = Str::slug($validated['name']);
        $validated['images'] = $this->storeImages($newImages);
        $validated['description_long'] = $this->sanitizeHtml($validated['description_long'] ?? null);

        unset($validated['new_images']);

        return $this->rooms->create($validated);
    }

    /** @param UploadedFile[] $newImages */
    public function update(Room $room, array $validated, array $newImages = []): Room
    {
        $validated['description_long'] = $this->sanitizeHtml($validated['description_long'] ?? null);

        // Galerie gérée depuis le formulaire : ordre et suppressions des photos
        // existantes (limitées à celles réellement rattachées à la chambre),
        // puis ajout des nouveaux uploads à la suite.
        if (array_key_exists('existing_images', $validated)) {
            $current = $room->images ?? [];
            $kept = array_values(array_intersect($validated['existing_images'] ?? [], $current));

            $this->deleteUploadedFiles(array_diff($current, $kept));

            $validated['images'] = array_merge($kept, $this->storeImages($newImages));
        } elseif ($newImages !== []) {
            $validated['images'] = array_merge($room->images ?? [], $this->storeImages($newImages));
        }

        unset($validated['new_images'], $validated['existing_images']);

        return $this->rooms->update($room, $validated);
    }

    /**
     * Supprime du disque les photos retirées, uniquement celles issues
     * d'uploads (storage/…) — jamais les images du catalogue versionné.
     */
    private function deleteUploadedFiles(array $paths): void
    {
        foreach ($paths as $path) {
            if (str_starts_with($path, 'storage/')) {
                Storage::disk('public')->delete(substr($path, strlen('storage/')));
            }
        }
    }

    public function deactivate(Room $room): Room
    {
        return $this->rooms->update($room, ['status' => 'inactive']);
    }

    /** Bascule rapide actif ↔ inactif depuis la liste. */
    public function toggleStatus(Room $room): Room
    {
        return $this->rooms->update($room, [
            'status' => $room->status === 'active' ? 'inactive' : 'active',
        ]);
    }

    /**
     * Suppression définitive : refusée si des réservations existent
     * (l'historique doit être conservé — désactiver dans ce cas).
     * Les photos uploadées (storage/…) sont retirées du disque ;
     * les images versionnées du catalogue ne sont jamais supprimées.
     */
    public function delete(Room $room): void
    {
        if ($room->reservations()->exists()) {
            throw ValidationException::withMessages([
                'room' => __('Impossible de supprimer : cette chambre a des réservations (l\'historique doit être conservé). Désactivez-la plutôt.'),
            ]);
        }

        $this->deleteUploadedFiles($room->images ?? []);
        $this->rooms->delete($room);
    }

    /** @param UploadedFile[] $files */
    private function storeImages(array $files): array
    {
        $paths = [];

        foreach ($files as $file) {
            $paths[] = 'storage/'.$file->store('rooms', 'public');
        }

        return $paths;
    }

    /**
     * Assainit le HTML produit par l'éditeur riche (Trix) : seules les balises
     * de mise en forme sont conservées, tout script ou attribut dangereux est retiré.
     */
    private function sanitizeHtml(?string $html): ?string
    {
        if (! $html) {
            return null;
        }

        $config = \HTMLPurifier_Config::createDefault();
        $config->set('Cache.DefinitionImpl', null);
        $config->set('HTML.Allowed', 'div,p,br,strong,b,em,i,del,ul,ol,li,h1,h2,h3,blockquote,pre,a[href]');
        $config->set('AutoFormat.RemoveEmpty', true);

        return (new \HTMLPurifier($config))->purify($html);
    }
}
