<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TradeItemImage extends Model
{
    protected $fillable = [
        'trade_item_id',
        'path',
        'original_name',
        'sort_order',
    ];

    protected static function booted(): void
    {
        static::deleting(function (TradeItemImage $image): void {
            if ($image->path) {
                Storage::disk('public')->delete($image->path);
            }
        });
    }

    public function item()
    {
        return $this->belongsTo(TradeItem::class, 'trade_item_id');
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->path);
    }
}
