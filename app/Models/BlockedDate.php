<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlockedDate extends Model
{
    protected $fillable = ['room_id', 'start_date', 'end_date', 'reason'];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
