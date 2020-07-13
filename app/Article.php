<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = [];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
