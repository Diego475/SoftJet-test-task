<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{

    /**
     *  @OA\Get(
     *      path="/api/v1/genres",
     *      description="Получить список жанров",
     *      @OA\Response(
     *          response="200",
     *          description=""
     *      )
     *  )
    */
    public function index()
    {
        return Genre::all();
    }

    /**
     *  @OA\Post(
     *      path="/api/v1/genres/",
     *      description="Создать данные жанра",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(
     *                  property="name",
     *                  type="string",
     *              )
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
    public function create(Request $request)
    {
        $request->validate(["name" => 'required']);
        Genre::create($request->all());
        return response()->json(["success" => true]);
    }

    /**
     *  @OA\Put(
     *      path="/api/v1/genres/{id}",
     *      description="Обновить данные жанра",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(
     *                  property="name",
     *                  type="string",
     *              )
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
    public function update(Request $request, $id)
    {
        $request->validate(["name" => 'required']);
        Genre::where('id', $id)->update($request->all());
        return response()->json(["success" => true]);
    }

    /**
     *  @OA\Get(
     *      path="/api/v1/genres/{id}",
     *      description="Получить жанр",
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
        return Genre::find($id);
    }

    /**
     *  @OA\Delete(
     *      path="/api/v1/genres/{id}",
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
        $genre = Genre::find($id);
        $genre->games()->detach();
        $genre->delete();
        return response()->json(["success" => true]);
    }
}
