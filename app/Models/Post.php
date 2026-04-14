<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        "artisan_id",
        "title",
        "description",
        "images",
        "category",
        "tags",
    ];

    protected $casts = [
        'images' => 'array',
        'tags' => 'array',
    ];

    public function artisan()
    {
        return $this->belongsTo(Artisan::class);
    }


    
    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }
            
}