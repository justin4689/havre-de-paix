<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'slug', 'name', 'name_en', 'tagline', 'tagline_en', 'sort_order', 'featured_room_id',
    ];

    /** Carte slug → libellé localisé, mémoïsée pour la durée de la requête. */
    private static ?array $labelMap = null;

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'category', 'slug');
    }

    /** Chambre affichée sur la carte d'accueil de la catégorie (facultatif). */
    public function featuredRoom(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'featured_room_id');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /** Libellé dans la langue courante (repli sur le français). */
    public function getLabelAttribute(): string
    {
        return app()->getLocale() === 'en' && $this->name_en !== null && $this->name_en !== ''
            ? $this->name_en
            : $this->name;
    }

    /** Tagline dans la langue courante (repli sur le français). */
    public function getTaglineLabelAttribute(): ?string
    {
        return app()->getLocale() === 'en' && $this->tagline_en !== null && $this->tagline_en !== ''
            ? $this->tagline_en
            : $this->tagline;
    }

    /** @return array<string, string> slug => libellé localisé */
    public static function labelMap(): array
    {
        return self::$labelMap ??= static::query()
            ->get(['slug', 'name', 'name_en'])
            ->mapWithKeys(fn (self $category) => [$category->slug => $category->label])
            ->all();
    }

    public static function flushLabelMap(): void
    {
        self::$labelMap = null;
    }
}
