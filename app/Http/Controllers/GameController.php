<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use App\Models\Game;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    /**
     *  @OA\Get(
     *      path="/api/v1/games",
     *      description="Получить список игр",
     *      @OA\Response(
     *          response="200",
     *          description=""
     *      )
     *  )
    */
    public function index()
    {
        $games = Game::all();
        
        return $games;
    }

    /**
     *  @OA\Post(
     *      path="/api/v1/games",
     *      description="Сохранить данные",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name","description","genres"},
     *              @OA\Property(
     *                  property="name",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="description",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="genres",
     *                  type="array",
     *                  @OA\Items(
     *                      type="integer",
     *                  ),
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              )
     *          )
     *      )
     *  )
    */
    public function create(GameRequest $request)
    {
        $request->validated();
        $game = Game::create(["name" => $request->name, "description" => $request->description]);

        foreach ($request->genres as $id) DB::table('games_genres')->insert(["game_id" => $game->id, "genre_id" => $id]);

        return response()->json(["success" => true]);
    }

    /**
     *  @OA\Put(
     *      path="/api/v1/games/{id}",
     *      description="Обновить данные",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name","description","genres"},
     *              @OA\Property(
     *                  property="name",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="description",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="genres",
     *                  type="array",
     *                  @OA\Items(
     *                      type="integer",
     *                  ),
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              )
     *          )
     *      )
     *  )
    */
    public function update(GameRequest $request, $id)
    {
        $request->validated();
        Game::where('id', $id)->update(["name" => $request->name, "description" => $request->description]);
        DB::table('games_genres')->where('game_id', $id)->delete();

        foreach ($request->genres as $id)  DB::table('games_genres')->insert(["game_id" => $id, "genre_id" => $id]);

        return response()->json(["success" => true]);
    }

    /**
     *  @OA\Get(
     *      path="/api/v1/games/{id}",
     *      description="Получить игру",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description=""
     *      )
     *  )
    */
    public function show($id)
    {
        $game = Game::where('id', $id)->first();
        return $game;
    }

    /**
     *  @OA\Delete(
     *      path="/api/v1/games/{id}",
     *      description="Удалить данные",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              )
     *          )
     *      )
     *  )
    */
    public function delete($id)
    {
        Game::where('id', $id)->delete();
        DB::table('games_genres')->where('game_id', $id)->delete();
        return response()->json(["success" => true]);
    }
}