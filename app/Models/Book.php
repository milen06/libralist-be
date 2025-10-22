<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'published_at' => 'date',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function ratings()
    {
        return $this->hasMany(BookRating::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'book_genres');
    }
}
