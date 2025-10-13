<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Temporarily commented out email verification
class User extends Authenticatable // implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        ];
    }
    /**
     * Get the user's avatars.
     */
    public function avatars()
    {
        return $this->hasMany(Avatar::class);
    }

    /**
     * Get the user's active avatar.
     */
    public function activeAvatar()
    {
        return $this->hasOne(Avatar::class)->where('is_active', true);
    }

    /**
     * Get the avatar URL for the user.
     */
    public function getAvatarAttribute()
    {
        $activeAvatar = $this->activeAvatar;
        
        if ($activeAvatar && $activeAvatar->path) {
            return asset('storage/' . $activeAvatar->path);
        }
        
        return null;
    }
}
