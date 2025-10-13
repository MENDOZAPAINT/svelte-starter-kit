<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Avatar extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'user_id',
        'filename',
        'original_name',
        'mime_type',
        'size',
        'path',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
