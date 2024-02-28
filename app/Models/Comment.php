<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //use HasFactory;
    public function article()
    {
        return $this->belongsTo(Article::class); //itt meghatározom, hogy minden egyes comment hozzá tartozik 'belongsTo' (!)egy article-höz.
    }
}
