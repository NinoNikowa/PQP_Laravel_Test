<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('movies_genres_movies', 'movie_movies_genre');

        Schema::table('movie_movies_genre', function (Blueprint $table) {
            $table->renameColumn('moviesgenre_id', 'movies_genre_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movie_movies_genre', function (Blueprint $table) {
            $table->renameColumn('movies_genre_id', 'moviesgenre_id');
        });
        Schema::rename('movie_movies_genre', 'movies_genres_movies');
    }
};
