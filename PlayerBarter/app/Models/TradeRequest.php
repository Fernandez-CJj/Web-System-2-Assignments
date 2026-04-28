<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradeRequest extends Model
{
    protected $fillable = [
        'item_id',
        'requester_id',
        'owner_id',
        'status',
        'requester_confirmed',
        'owner_confirmed',
        'completed_at',
        'message',
    ];

    protected function casts(): array
    {
        return [
            'requester_confirmed' => 'boolean',
            'owner_confirmed' => 'boolean',
            'completed_at' => 'datetime',
        ];
    }

    public function item()
    {
        return $this->belongsTo(TradeItem::class, 'item_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function messages()
    {
        return $this->hasMany(TradeMessage::class)->oldest();
    }

    public function participantIds(): array
    {
        return [$this->requester_id, $this->owner_id];
    }
}
