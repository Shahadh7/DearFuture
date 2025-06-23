<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryLog extends Model
{
    protected $fillable = [
        'capsule_id',
        'user_id',
        'delivery_date',
        'status',
        'notes'
    ];

    protected $casts = [
        'delivery_date' => 'datetime',
    ];

    public function capsule(): BelongsTo
    {
        return $this->belongsTo(Capsule::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
