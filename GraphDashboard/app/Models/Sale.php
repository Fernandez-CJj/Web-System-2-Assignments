<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'amount',
        'sale_date',
        'channel',
        'region',
        'orders',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'sale_date' => 'date',
            'orders' => 'integer',
        ];
    }
}
