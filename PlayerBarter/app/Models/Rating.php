<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['trade_request_id', 'rater_id', 'rated_user_id', 'score', 'comment'];

    public function tradeRequest()
    {
        return $this->belongsTo(TradeRequest::class);
    }

    public function rater()
    {
        return $this->belongsTo(User::class, 'rater_id');
    }

    public function ratedUser()
    {
        return $this->belongsTo(User::class, 'rated_user_id');
    }
}
