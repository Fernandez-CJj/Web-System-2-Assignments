<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'reporter_id',
        'reported_user_id',
        'trade_item_id',
        'reason',
        'details',
        'status',
        'admin_notes',
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function reportedUser()
    {
        return $this->belongsTo(User::class, 'reported_user_id');
    }

    public function item()
    {
        return $this->belongsTo(TradeItem::class, 'trade_item_id');
    }
}
