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
        'donor_name',
        'status',
        'mollie_payment_id',
        'paid_at',
        'dua_request_enabled',
        'dua_request_text',
        'dua_request_anonymous',
        'dua_fulfilled_at',
        'dua_show_on_ticker',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'dua_request_enabled' => 'bool',
        'dua_request_anonymous' => 'bool',
        'dua_fulfilled_at' => 'datetime',
        'dua_show_on_ticker' => 'bool',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
