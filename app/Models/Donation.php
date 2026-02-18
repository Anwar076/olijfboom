<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'amount',
        'status',
        'mollie_payment_id',
        'paid_at',
        'dua_request_enabled',
        'dua_request_text',
        'dua_fulfilled_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'dua_request_enabled' => 'bool',
        'dua_fulfilled_at' => 'datetime',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
