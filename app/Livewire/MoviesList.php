<?php

namespace App\Livewire;

use App\Models\Movie;
use Livewire\Component;

class MoviesList extends Component
{
    public function render()
    {
        $movies = Movie::all();

        return view('livewire.movies-list', compact('movies'))->layout('layouts.app');
    }
}
