<?php

namespace App\Http\Controllers;

use App\Models\Game;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\GuzzleRateLimiterMiddleware\RateLimiterMiddleware;

class ImporterController extends Controller
{

    private $httpClient;

    public function __construct()
    {
        $stack = HandlerStack::create();
        $stack->push(RateLimiterMiddleware::perSecond(3));
        
        $this->httpClient = new Client([
            'handler' => $stack,
        ]);
    }

    public function index()
    {
        $games = Game::all()->toArray();

        return new JsonResponse($games);
    }

    public function import()
    {

        $currentGamesIds = Game::pluck('id');

        $games = $this->getGames();

        $importedGamesCounter = 0;

        foreach ($games as $game) {

            $importedGameId = $game['id'];

            $gameMinimumSystemRequirmenets = [];

           
            if (!in_array($importedGameId, $currentGamesIds->toArray())) {
                $gameDetails = $this->getGame($importedGameId);

                $gameMinimumSystemRequirmenets = $gameDetails['minimum_system_requirements'] ?? [];
    
                Game::create([
                    'id' => $game['id'],
                    'title' => $game['title'],
                    'thumbnail' => $game['thumbnail'],
                    'short_description' => $game['short_description'],
                    'game_url' => $game['game_url'],
                    'genre' => $game['genre'],
                    'platform' => $game['platform'],
                    'publisher' => $game['publisher'],
                    'developer' => $game['developer'],
                    'release_date' => $game['release_date'],
                    'profile_url' => $game['profile_url'],
                    'minimum_system_requirements' => json_encode($gameMinimumSystemRequirmenets)
                ]);

                $importedGamesCounter += 1;

            }
        }

        return new JsonResponse([
            'games_imported' => $importedGamesCounter
        ]);
    }

    private function getGames()
    {
        $recipeapi = "https://www.mmobomb.com/api1/games";

        $params = [
            // 'q'       => 'chicken',
            // 'app_id'  => $APP,
            // 'app_key' => $KEY,
            // 'from'    => 0,
            // 'to'      => 3,
            // 'health'  => 'alcohol-free',
        ];

        $response = $this->httpClient->get($recipeapi, [
            'query' => $params,
            'verify' => false,
        ]);


        $data = (string) $response->getBody();

        return json_decode($data, true);
    }

    private function getGame($id)
    {
        \Log::info('Get game details: ' . $id);

        $recipeapi = "https://www.mmobomb.com/api1/game";

        $params = [
            'id' => $id
        ];

        $response = $this->httpClient->get($recipeapi, [
            'query' => $params,
            'verify' => false,
        ]);

        $data = (string) $response->getBody();

        return json_decode($data, true);
    }
}
