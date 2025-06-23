<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;

class Capsule extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'recipient_email',
        'unlock_date',
        'status',
        'delivery_token',
        'delivered_at',
    ];

    protected $casts = [
        'unlock_date' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    protected $dates = [
        'unlock_date',
        'delivered_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function deliveryLogs(): HasMany
    {
        return $this->hasMany(DeliveryLog::class);
    }

    public function isLocked(): bool
    {
        return $this->status === 'locked';
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isDelivered(): bool
    {
        return $this->status === 'delivered';
    }

    public function canBeUnlocked(): bool
    {
        return $this->unlock_date->isPast() && $this->status === 'locked';
    }

    public function generateDeliveryToken(): void
    {
        $this->update([
            'delivery_token' => Str::random(64),
        ]);
    }

    public function markAsDelivered(): void
    {
        $this->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeReadyForDelivery($query)
    {
        return $query->where('status', 'locked')
                    ->where('unlock_date', '<=', now());
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('attachments')
            ->acceptsMimeTypes([
                'image/jpeg',
                'image/png',
                'image/gif',
                'image/svg+xml',
                'video/mp4',
                'video/quicktime',
                'audio/ogg',
                'video/ogg',
                'audio/wav',
                'audio/mpeg',
            ]);
    }
}
