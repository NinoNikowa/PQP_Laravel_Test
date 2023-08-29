<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'title', 'tagline', 'homepage', 'poster_path', 'release_date', 'vote_average', 'vote_count', 'is_trending'];

    public function moviesGenres()
    {
        return $this->belongsToMany(MoviesGenre::class);
    }
}
