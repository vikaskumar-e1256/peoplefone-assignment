<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'notification_for',
        'type',
        'text',
        'expiration',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'notification_for');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'notification_user')->withPivot('is_read')->withTimestamps();
    }
}
