<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    //use HasFactory;
    protected $fillable = ['title', 'article_text'];
    
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'article_tag');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class); // itt azt definiáltuk, hogy egy cikkhez több 'hasMany' comment is tartozhat
    }
}
