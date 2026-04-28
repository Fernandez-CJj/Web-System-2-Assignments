<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'status',
        'preferred_games',
        'trading_preferences',
        'suspended_until',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'suspended_until' => 'datetime',
        ];
    }

    public function items()
    {
        return $this->hasMany(TradeItem::class);
    }

    public function sentTradeRequests()
    {
        return $this->hasMany(TradeRequest::class, 'requester_id');
    }

    public function receivedTradeRequests()
    {
        return $this->hasMany(TradeRequest::class, 'owner_id');
    }

    public function receivedRatings()
    {
        return $this->hasMany(Rating::class, 'rated_user_id');
    }

    public function notifications()
    {
        return $this->hasMany(AppNotification::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function ratingAverage(): float
    {
        return round((float) $this->receivedRatings()->avg('score'), 1);
    }
}
