<?php

namespace App\Services;

use App\Models\Room;
use App\Repositories\Contracts\RoomRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class RoomCatalogService
{
    public const PER_PAGE = 8;

    public function __construct(
        private readonly RoomRepositoryInterface $rooms,
        private readonly AvailabilityService $availability,
    ) {}

    /**
     * Catalogue public : chambres filtrées (et disponibles si dates fournies),
     * paginées, avec compteurs par vue et bornes de prix pour le panneau de filtres.
     *
     * @param array $filters capacity, view, price_max, sort, check_in, check_out
     */
    public function catalog(array $filters, int $page, string $path, array $query): array
    {
        $checkIn  = $filters['check_in'] ?? null;
        $checkOut = $filters['check_out'] ?? null;

        $rooms = $this->rooms->activeFiltered($filters, $filters['sort'] ?? 'price_asc');

        if ($checkIn && $checkOut && $checkIn < $checkOut) {
            $rooms = $rooms
                ->filter(fn (Room $room) => $this->availability->isRoomAvailable($room, $checkIn, $checkOut))
                ->values();
        }

        // Pagination sur la collection : le filtre de disponibilité est en PHP,
        // une pagination SQL fausserait les comptes par page.
        $paginated = new LengthAwarePaginator(
            $rooms->forPage($page, self::PER_PAGE)->values(),
            $rooms->count(),
            self::PER_PAGE,
            $page,
            ['path' => $path, 'query' => $query],
        );

        return [
            'rooms'       => $paginated,
            'viewCounts'  => $this->viewCounts(),
            'priceBounds' => $this->priceBounds(),
        ];
    }

    public function featured(int $limit = 3): Collection
    {
        return $this->rooms->featured($limit);
    }

    public function findBySlug(string $slug): Room
    {
        return $this->rooms->findBySlugOrFail($slug);
    }

    public function findById(int $id): Room
    {
        return $this->rooms->findOrFail($id);
    }

    public function similarTo(Room $room, int $limit = 2): Collection
    {
        return $this->rooms->similarTo($room, $limit);
    }

    private function viewCounts(): Collection
    {
        return $this->rooms->allActive()->countBy('view');
    }

    private function priceBounds(): array
    {
        $active = $this->rooms->allActive();

        if ($active->isEmpty()) {
            return ['min' => 0, 'max' => 200000];
        }

        return [
            'min' => (int) floor($active->min('price_per_night') / 5000) * 5000,
            'max' => (int) ceil($active->max('price_per_night') / 5000) * 5000,
        ];
    }
}
