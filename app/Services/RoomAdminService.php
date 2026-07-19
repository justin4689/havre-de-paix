<?php

namespace App\Services;

use App\Models\Room;
use App\Repositories\Contracts\RoomRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

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
        $validated['slug']             = Str::slug($validated['name']);
        $validated['images']           = $this->storeImages($newImages);
        $validated['description_long'] = $this->sanitizeHtml($validated['description_long'] ?? null);

        unset($validated['new_images']);

        return $this->rooms->create($validated);
    }

    /** @param UploadedFile[] $newImages */
    public function update(Room $room, array $validated, array $newImages = []): Room
    {
        $validated['description_long'] = $this->sanitizeHtml($validated['description_long'] ?? null);

        if ($newImages !== []) {
            $validated['images'] = array_merge($room->images ?? [], $this->storeImages($newImages));
        }

        unset($validated['new_images']);

        return $this->rooms->update($room, $validated);
    }

    public function deactivate(Room $room): Room
    {
        return $this->rooms->update($room, ['status' => 'inactive']);
    }

    /** @param UploadedFile[] $files */
    private function storeImages(array $files): array
    {
        $paths = [];

        foreach ($files as $file) {
            $paths[] = 'storage/' . $file->store('rooms', 'public');
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
