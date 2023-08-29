<?php

namespace App\Services\TheMovieDB;

use App\Models\Movie;
use App\Models\MoviesGenre;
use Facades\App\Services\TheMovieDB\TheMovieDbAPI;

class TheMovieDbUpdater
{
    protected $fields = ['title', 'tagline', 'homepage', 'poster_path', 'release_date', 'vote_average', 'vote_count'];

    private $trendingMovies = [];

    private $moviesGenres = [];

    private $log = [
        'trending_ids_count' => 0,
        'updated_movies' => 0,
        'created_movies' => 0,
        'created_genres' => 0,
        'movie_data_error' => 0,
        'movies_isnt_trending' => 0,
    ];

    public function update(): array
    {
        // chargement de la liste des filmes à mettre à jour
        $this->loadTrendingMovies();

        // récupération de la liste des éléments
        $moviesIds = $this->getTrendingMoviesIds();
        $genresIds = $this->getTrendingMoviesGenresIds();

        // on charge met de côté les genres qui existe déjà, cela permettra de facilement détecté les genres à créer
        $moviesGenreResults = MoviesGenre::whereIn('id', $genresIds)->get();
        foreach ($moviesGenreResults as $MoviesGenre) {
            $this->moviesGenres[$MoviesGenre->id] = $MoviesGenre;
        }

        $this->log['trending_ids_count'] = count($moviesIds);

        foreach ($moviesIds as $movieId) {
            // récupération de la donnée tierce
            $movieData = TheMovieDbAPI::getMovie($movieId);
            if ($movieData) {
                $this->movieUpdater($movieId, $movieData);
            } else {
                $this->log['movie_data_error']++;
            }
        }

        // Les films qui ne sont pas dans le flux ne sont plus tendance, on les désactives
        if ($moviesIds) {
            $this->log['movies_isnt_trending'] = Movie::whereNotIn('id', $moviesIds)->update(['is_trending' => false]);
        }

        return $this->log;
    }

    private function movieUpdater($movieId, $movieData)
    {
        // Création / Mise à jour du film
        $movie = Movie::find($movieId);
        $data = $this->movieDataParser($movieData);
        if (! $movie) {
            $movie = new Movie(['id' => $movieId, ...$data]);
            $movie->save();
            $this->log['created_movies']++;
        } else {
            $movie->update($data);
            $this->log['updated_movies']++;
        }

        // Attache le film a la catégorisation genre
        $genres = [];
        // création des genres non présent en bdd, ajout des gens a une list pour sync ensuite
        foreach ($movieData['genres'] as $genre) {
            if (! isset($this->moviesGenres[$genre['id']])) {
                $this->createMoviesGenre($genre['id'], $genre['name']);
            }
            $genres[] = $genre['id'];
        }

        $movie->moviesGenres()->sync($genres);

    }

    private function createMoviesGenre($id, $name)
    {
        $MoviesGenre = new MoviesGenre(['id' => $id, 'name' => $name]);
        $MoviesGenre->save();
        $this->moviesGenres[$id] = $MoviesGenre;

        $this->log['created_genres']++;

        return $MoviesGenre;
    }

    private function movieDataParser($movieData): array
    {
        $data = [];

        foreach ($movieData as $key => $val) {
            if (in_array($key, $this->fields)) {
                $data[$key] = $val;
            }
        }

        return $data;
    }

    private function loadTrendingMovies()
    {
        $this->trendingMovies = TheMovieDbAPI::getTrendingMovies();
    }

    private function getTrendingMoviesIds(): array
    {
        return array_column($this->trendingMovies, 'id');
    }

    private function getTrendingMoviesGenresIds(): array
    {
        $ids = [];

        $arrayList = array_column($this->trendingMovies, 'genre_ids');
        foreach ($arrayList as $k => $v) {
            $ids = array_merge($ids, $v);
        }

        return array_keys(array_flip($ids));
    }
}
