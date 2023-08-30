## Installation

### 1 - Récupération du projet :

    git clone https://github.com/NinoNikowa/PQP_Laravel_Test.git

### 2 - Configuration du .env :

Reprendre le fichier .env.example et le renommer en .env, ou configurer le .env pour votre environnement.
Ne pas oublier d'ajouter la variable : THE_MOVIE_DB_BEARER 
Elle doit contenir la clef BEARER fournie.

### 3 - Installation des dépendances :

    composer install
    npm install
    npm run build

### 4 - Mise en place d'un environnement de dev
On lance sail pour mettre en place le conteneur

    ./vendor/bin/sail up

### 5 - Mise en place de la base de données

    ./vendor/bin/sail artisan migrate

### 6 - Mettre en place les taches planifiées 

Configurer selon la doc de la laravel pour la production
https://laravel.com/docs/10.x/scheduling#running-the-scheduler
     
    * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1

Dans le cas d'un environnement de dev : 
    
    php artisan schedule:work

### 7 - C'est en place
Il ne vous reste plus qu'à ajouter un utilisateur au back office, et a lancer une sync des films via la commande ci-dessous afin de remplir la base de données.
 
## Ajouter un utilisateur pour le back office 

La commande suivante permet d'ajouter un utilisateur en étant guidé :

    ./vendor/bin/sail artisan app:create-user

## Forcer la mise à jour des films

La commande suivante permet de lancer la mise à jour des films manuellement.

    ./vendor/bin/sail artisan app:movies-update

