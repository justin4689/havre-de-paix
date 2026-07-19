<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'slug', 'name', 'description_short', 'description_long',
        'capacity_adults', 'capacity_children', 'size_m2',
        'bed_type', 'floor', 'view', 'amenities', 'images',
        'price_per_night', 'min_nights', 'status',
    ];

    protected $casts = [
        'amenities' => 'array',
        'images'    => 'array',
    ];

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function blockedDates(): HasMany
    {
        return $this->hasMany(BlockedDate::class);
    }

    // Disponibilité → App\Services\AvailabilityService
    // Prix du séjour → App\Services\PricingService

    /**
     * Description longue prête pour l'affichage : HTML assaini de l'éditeur riche,
     * ou texte brut hérité (converti avec des sauts de ligne).
     */
    public function getDescriptionLongHtmlAttribute(): string
    {
        $value = (string) $this->description_long;

        return str_contains($value, '<') ? $value : nl2br(e($value));
    }

    public function getFirstImageAttribute(): string
    {
        $images = $this->images ?? [];
        return $images[0] ?? 'images/placeholder.svg';
    }

    public function getViewLabelAttribute(): string
    {
        return match ($this->view) {
            'sea'    => 'Vue mer',
            'lagoon' => 'Vue lagune',
            'pool'   => 'Vue piscine',
            default  => 'Vue jardin',
        };
    }

    public function getBedTypeLabelAttribute(): string
    {
        return match ($this->bed_type) {
            'king'   => 'King size',
            'double' => 'Grand lit double',
            'twin'   => 'Lits jumeaux',
            default  => 'Lit simple',
        };
    }

    public static function findBySlug(string $slug): self
    {
        return static::where('slug', $slug)->where('status', 'active')->firstOrFail();
    }
}
