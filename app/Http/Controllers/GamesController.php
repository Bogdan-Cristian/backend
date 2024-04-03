<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class GamesController extends Controller
{
    
    public function index()
    {
        $games = Game::all()->toArray();

        return new JsonResponse($games);
    }

    private function generateRandomSequence($length = 5) {
        $sequence = '';
        for ($i = 0; $i < $length; $i++) {
            $sequence .= mt_rand(0, 9);
        }
        return $sequence;
    }
    public function store(Request $request) {

    
        $data = [
            'id' => $this->generateRandomSequence(),
            'title' => $request->input('title'),
            'thumbnail' => $request->input('thumbnail'),
            'short_description' => $request->input('short_description'),
            'game_url' => $request->input('game_url'),
            'genre' => $request->input('genre'),
            'platform' => $request->input('platform'),
            'publisher' => $request->input('publisher'),
            'developer' => $request->input('developer'),
            'release_date' => $request->input('release_date'),
            'profile_url' => $request->input('profile_url'),
            'minimum_system_requirements' => json_encode($request->input('minimum_system_requirements') ?? [])
        ];

        try {
            $game = Game::create($data);
            return new JsonResponse([
                'status' => 'success',
                'game' => $game
            ]);
        } catch(\Exception $e) {
            return new JsonResponse([
                'status' => 'error',
                'msg' => $e->getMessage()
            ]);
        }
    }
}
