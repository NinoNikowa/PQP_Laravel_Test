<?php

namespace App\Livewire;

use App\Models\Movie as MovieModel;
use Livewire\Component;

class Movie extends Component
{
    public function mount($id)
    {
        $this->id = $id;
    }

    public function render()
    {
        $movie = MovieModel::findOrFail($this->id);

        return view('livewire.movie', compact('movie'))->layout('layouts.app');
    }
}
