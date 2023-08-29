<?php

namespace App\Console\Commands;

use App\Services\TheMovieDB\TheMovieDbUpdater;
use Illuminate\Console\Command;

class moviesUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:movies-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Met à jours la bdd des filmes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $timeStart = microtime(true);

        $this->info('Mise à jour en cours ...');
        $update = new TheMovieDbUpdater();
        $result = $update->update();
        foreach ($result as $key => $val) {
            $this->line($key.' : '.$val);
        }

        $diff = microtime(true) - $timeStart;
        $sec = intval($diff);

        if ($result['trending_ids_count'] == 0) {
            $this->error("Aucun film n'a pu être récupéré.");
        } elseif ($result['movie_data_error'] > 0) {
            $this->error("Des films n'ont pas pu être mis à jour.");
        } else {
            $this->info('Mise à jour terminée en '.$sec.' secondes');
        }

    }
}
