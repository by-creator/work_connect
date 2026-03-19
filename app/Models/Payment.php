<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'mission_id',
        'client_id',
        'freelance_id',
        'amount',
        'commission',
        'net_amount',
        'method',
        'status',
        'transaction_ref',
        'escrowed_at',
        'released_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'commission' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'escrowed_at' => 'datetime',
        'released_at' => 'datetime',
    ];

    public function mission(): BelongsTo
    {
        return $this->belongsTo(Mission::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function freelance(): BelongsTo
    {
        return $this->belongsTo(User::class, 'freelance_id');
    }

    public function methodLabel(): string
    {
        return match ($this->method) {
            'orange_money' => 'Orange Money',
            'wave' => 'Wave',
            'free_money' => 'Free Money',
            'card' => 'Carte bancaire',
            'bank_transfer' => 'Virement bancaire',
            default => $this->method ?? 'Non défini',
        };
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'En attente',
            'escrowed' => 'Fonds bloqués',
            'released' => 'Fonds libérés',
            'refunded' => 'Remboursé',
            'disputed' => 'En litige',
            default => $this->status,
        };
    }
}
