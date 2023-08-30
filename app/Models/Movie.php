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

    /**
     * Retourne l'url compléte d'un poster, ou un string vide si vide
     * Gére le cas d'une url mise en dure depuis le BO
     *
     * @return mixed|string
     */
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
        return config('services.themoviedb.image_base_url').$this->poster_path;
    }
}
