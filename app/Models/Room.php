<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'slug', 'name', 'description_short', 'description_long',
        'capacity_adults', 'capacity_children', 'size_m2',
        'bed_type', 'floor', 'category', 'amenities', 'images',
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

    public const CATEGORIES = [
        'mini-suite' => 'Mini Suite',
        'standard'   => 'Standard',
        'executive'  => 'Executive',
        'open-space' => 'Open Space',
    ];

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? 'Standard';
    }

    public function getBedTypeLabelAttribute(): string
    {
        return match ($this->bed_type) {
            'king'   => __('King size'),
            'double' => __('Grand lit double'),
            'twin'   => __('Lits jumeaux'),
            default  => __('Lit simple'),
        };
    }

    public static function findBySlug(string $slug): self
    {
        return static::where('slug', $slug)->where('status', 'active')->firstOrFail();
    }
}
