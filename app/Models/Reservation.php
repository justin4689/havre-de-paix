<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $fillable = [
        'ref', 'room_id', 'guest_name', 'guest_email', 'guest_phone',
        'check_in', 'check_out', 'nights', 'guests', 'total_price',
        'special_requests', 'status', 'cancel_token', 'cancelled_at',
    ];

    protected $casts = [
        'check_in'     => 'date',
        'check_out'    => 'date',
        'cancelled_at' => 'datetime',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    // Génération de la référence → App\Services\ReservationService::nextRef()

    public function isCancellable(): bool
    {
        if ($this->status !== 'confirmed') {
            return false;
        }
        // Annulation gratuite jusqu'à 48h avant l'arrivée
        return now()->addHours(48)->lt($this->check_in);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'confirmed'  => 'Confirmée',
            'cancelled'  => 'Annulée',
            'modified'   => 'Modifiée',
            default      => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'confirmed' => 'green',
            'cancelled' => 'red',
            'modified'  => 'yellow',
            default     => 'gray',
        };
    }
}
