<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradeItem extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'game_category',
        'rarity',
        'availability_status',
        'description',
    ];

    public const TYPES = ['Cosmetic Item', 'Collectible Item', 'Game Resource', 'Digital Collectible'];
    public const RARITIES = ['common', 'uncommon', 'rare', 'epic', 'legendary', 'limited'];
    public const STATUSES = ['available', 'reserved', 'traded', 'hidden'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tradeRequests()
    {
        return $this->hasMany(TradeRequest::class, 'item_id');
    }
}
