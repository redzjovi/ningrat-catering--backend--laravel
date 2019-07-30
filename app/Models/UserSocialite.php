<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSocialite extends Model
{
    use \App\Traits\UserSocialiteTrait;

    protected $fillable = [
        'user_id',
        'provider',
        'provider_id',
        'data',
    ];

    protected $table = 'user_socialite';

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
