<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Mission extends Model
{
    protected $fillable = [
        'client_id',
        'category_id',
        'freelance_id',
        'title',
        'description',
        'budget',
        'deadline',
        'skills_required',
        'status',
        'duration',
        'attachment',
    ];

    protected $casts = [
        'skills_required' => 'array',
        'deadline' => 'date',
        'budget' => 'decimal:2',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function freelance(): BelongsTo
    {
        return $this->belongsTo(User::class, 'freelance_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'open' => 'Ouverte',
            'in_progress' => 'En cours',
            'completed' => 'Terminée',
            'cancelled' => 'Annulée',
            'disputed' => 'En litige',
            default => $this->status,
        };
    }
}
