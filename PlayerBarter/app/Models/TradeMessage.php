<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradeMessage extends Model
{
    protected $fillable = [
        'trade_request_id',
        'user_id',
        'body',
    ];

    public function tradeRequest()
    {
        return $this->belongsTo(TradeRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
