<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $guarded = ['id'];

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_genres');
    }
}
