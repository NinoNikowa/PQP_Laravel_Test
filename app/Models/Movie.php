<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'title', 'tagline', 'overview', 'homepage', 'poster_path', 'release_date', 'vote_average', 'vote_count', 'is_trending', 'disable_sync'];

    public function moviesGenres()
    {
        return $this->belongsToMany(MoviesGenre::class);
    }

    public function getPosterAttribute()
    {
        if (! $this->poster_path) {
            // si pas d'image on retourne rien
            return '';
        }

        if (preg_match('/^http/i', $this->poster_path)) {
            // si le path commence par http, il s'agit d'une url complete surement indiqué dans le back office
            // on retourne l'adresse
            return $this->poster_path;
        }

        // retourne la miniature du poster
        return 'https://image.tmdb.org/t/p/w200'.$this->poster_path;
    }
}
