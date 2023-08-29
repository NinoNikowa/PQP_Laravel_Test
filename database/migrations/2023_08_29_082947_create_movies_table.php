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
        Schema::create('movies', function (Blueprint $table) {
            $table->unsignedBiginteger('id')->unique();
            $table->timestamps();
            $table->string('title');
            $table->string('tagline');
            $table->string('homepage');
            $table->string('poster_path');
            $table->date('release_date');
            $table->float('vote_average', 2, 1);
            $table->integer('vote_count');
            $table->boolean('is_trending')->default(true);

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
