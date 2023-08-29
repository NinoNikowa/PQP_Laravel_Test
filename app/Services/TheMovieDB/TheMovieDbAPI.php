<?php

namespace App\Services\TheMovieDB;

use Illuminate\Support\Facades\Http;

class TheMovieDbAPI
{
    private $api_url = 'https://api.themoviedb.org/3';

    private $headers = ['accept' => 'application/json'];

    private $defaultParams = ['language' => 'fr-FR'];

    private $requestLimitPerSecond = 1;

    public function __construct()
    {
        $apiBearerKey = config('services.themoviedb.bearer');
        if ($apiBearerKey) {
            $this->headers['Authorization'] = 'Bearer '.$apiBearerKey;
        }
    }

    /**
     * Retourne la liste des films tel que l'api le retourne, uniquement le tableau de results
     */
    public function getTrendingMovies(): array
    {
        $endpoint = '/trending/movie/day';
        $result = $this->request($endpoint);
        if (! empty($result)) {
            return $result['results'];
        }

        return [];
    }

    /**
     * Retourne les détails du film tel que l'api le retourne
     */
    public function getMovie(int $id): array
    {
        $endpoint = '/movie/'.$id;
        $result = $this->request($endpoint);

        return $result;
    }

    /**
     * Requête vers l'api tierce
     */
    private function request(string $endpoint = '/', array $params = []): array
    {
        // ajout des params par défaut
        $params = array_merge($this->defaultParams, $params);

        $response = Http::retry(3, 1000)
            ->withHeaders($this->headers)
            ->withQueryParameters($params)
            ->get($this->api_url.$endpoint);

        if (! $response->successful()) {
            return [];
        }

        return $response->json();
    }
}
