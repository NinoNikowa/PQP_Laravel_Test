<?php

namespace App\Console\Commands;

use Facades\App\Actions\Fortify\CreateNewUser;
use Illuminate\Console\Command;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Création d'un utilisateur";

    /**
     * Execute the console command.
     */
    public function handle()
    {

        // récupération des informations
        $input = [
            'name' => $this->ask('Nom d‘utilisateur'),
            'email' => $this->ask('Adresse email'),
            'password' => $this->secret('Mot de passe'),
            'password_confirmation' => $this->secret('Confirmez le mot de passe'),
        ];

        try {
            // création de l'utilisateur
            $user = CreateNewUser::create($input);
        } catch (\Exception $e) {
            // si une erreur, affichage de l'erreur
            $this->error($e->getMessage());

            return;
        }

        // Message de validation
        $this->info('Bienvenue '.$user->name);
    }
}
