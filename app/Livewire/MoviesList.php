<?php

namespace App\Livewire;

use App\Models\Movie;
use Livewire\Component;
use Livewire\WithPagination;

class MoviesList extends Component
{
    use WithPagination;

    public function render()
    {

        $movies = Movie::where('is_trending', true)->paginate(10);

        return view('livewire.movies-list', compact('movies'))->layout('layouts.app');
    }
}
