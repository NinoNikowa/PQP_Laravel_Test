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
        Schema::create('movies_genres_movies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('moviesgenre_id');
            $table->unsignedBiginteger('movie_id');

            $table->foreign('moviesgenre_id')->references('id')
                ->on('movies_genres')->onDelete('cascade');
            $table->foreign('movie_id')->references('id')
                ->on('movies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies_genres_movies');
    }
};
