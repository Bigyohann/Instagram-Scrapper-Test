<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class InstagramPost extends Model
{
    use HasFactory;

    protected $table = 'instagram_posts';
    protected $fillable = [
        'profileId',
        'instagramId',
        'imageUrl',
        'caption',
        'commentCount',
        'likedCount'
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(InstagramProfile::class);
    }
}
