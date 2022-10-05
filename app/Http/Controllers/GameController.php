<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use App\Models\Game;

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
        return Game::with('genres')->get();
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
        $game->genres()->attach($request->genres);
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
        $game = Game::find($id);
        $game->update(["name" => $request->name, "description" => $request->description]);
        $game->genres()->detach();
        $game->genres()->attach($request->genres);
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
        return Game::where('id', $id)->with('genres')->first();
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
        $game = Game::find($id);
        $game->genres()->detach();
        $game->delete();
        return response()->json(["success" => true]);
    }
}