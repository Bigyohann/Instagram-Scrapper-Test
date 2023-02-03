<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstagramProfile extends Model
{
    use HasFactory;

    protected $table = 'instagram_profiles';
    protected $fillable = [
        'username',
        'instagramId',
        'profilePictureUrl',
        'biography',
        'followedCount',
        'followerCount',
        'mediaCount',
    ];
    public function posts(): HasMany
    {
        return $this->hasMany(InstagramPost::class, 'profileId');
    }
}
