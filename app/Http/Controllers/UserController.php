<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *      path="/players",
     *      operationId="getPlayersList",
     *      tags={"Players"},
     *      summary="Get list of players",
     *      description="Returns list of players",
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *           @OA\JsonContent(
     *              type="object",
     *              example={
     *                    0: {
     *                          "id": 1,
     *                          "name": "Jozef Nový",
     *                          "elo": 2650,
     *                          "title": "GM",
     *                          "category": "CH24",
     *                      },
     *                    1: {
     *                          "id": 2,
     *                          "name": "František Starý",
     *                          "elo": 2600,
     *                          "title": "GM",
     *                          "category": "CH24",
     *                     },
     *                    2: {
     *                          "id": 3,
     *                          "name": "Samuel Halčin",
     *                          "elo": 2477,
     *                          "title": "IM",
     *                          "category": "CH18",
     *                    },
     *                    3: {
     *                          "id": 3,
     *                          "name": "Anna Lizáková",
     *                          "elo": 2311,
     *                          "title": "FM",
     *                          "category": "D18",
     *                    },
     *             }
     *          )
     *       ),
     *     )
     */
    public function index()
    {
        return new  UserResource(User::all());
    }

    /**
     * @OA\Put(
     *      path="/players/storeBulk",
     *      operationId="storeBulkPlayers",
     *      tags={"Players"},
     *      summary="Store list of players",
     *      description="Returns whether operation was successful.",
     *      @OA\RequestBody(
     *          required=true,
     *           @OA\JsonContent(
     *              type="object",
     *              example={
     *                    0: {
     *                          "name": "Jozef Nový",
     *                          "elo": 2650,
     *                          "title": "GM",
     *                          "category": "CH24",
     *                      },
     *                    1: {
     *                          "name": "František Starý",
     *                          "elo": 2600,
     *                          "title": "GM",
     *                          "category": "CH24",
     *                     },
     *                    2: {
     *                          "name": "Samuel Halčin",
     *                          "elo": 2477,
     *                          "title": "IM",
     *                          "category": "CH18",
     *                    },
     *                    3: {
     *                          "name": "Anna Lizáková",
     *                          "elo": 2311,
     *                          "title": "FM",
     *                          "category": "D18",
     *                    },
     *             }
     *          )
     *       ),
     *       @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *       @OA\Response(
     *          response=500,
     *          description="Something went wrong.",
     *       ),
     *     )
     */
    public function storeBulk()
    {
        //
    }

	 /**
     * @OA\Get(
     *      path="/standings",
     *      operationId="getStandings",
     *      tags={"Standings"},
     *      summary="Get standings",
     *      @OA\Parameter(
     *          name="group_by_category",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="bool"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="round",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      description="Returns standings after last round if not specified otherwise.",
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *           @OA\JsonContent(
     *              type="object",
     *              example={
     *                    0: {
     *                          "id": 1,
     *                          "name": "Jozef Nový",
     *                          "elo": 2650,
     *                          "title": "GM",
     *                          "category": "CH24",
     *                          "points": 3
     *                      },
     *                    1: {
     *                          "id": 2,
     *                          "name": "František Starý",
     *                          "elo": 2600,
     *                          "title": "GM",
     *                          "category": "CH24",
     *                          "points": 2
     *                     },
     *                    2: {
     *                          "id": 3,
     *                          "name": "Samuel Halčin",
     *                          "elo": 2477,
     *                          "title": "IM",
     *                          "category": "CH18",
     *                          "points": 5.5
     *                    },
     *                    3: {
     *                          "id": 3,
     *                          "name": "Anna Lizáková",
     *                          "elo": 2311,
     *                          "title": "FM",
     *                          "category": "D18",
     *                          "points": 3.5
     *                    },
     *             }
     *          ),
     *     ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
	public function standings()
	{
		return new  UserResource(User::all());
	}


    /**
     * @OA\Post(
     *      path="/players",
     *      operationId="storePlayer",
     *      tags={"Players"},
     *      summary="Store new player",
     *      description="Returns player data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="František Nový"),
     *              @OA\Property(property="elo", type="integer", example="1000"),
     *              @OA\Property(property="category", type="string", example="CH20"),
     *              @OA\Property(property="title", type="string", example="null"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example="1"),
     *              @OA\Property(property="name", type="string", example="František Nový"),
     *              @OA\Property(property="elo", type="integer", example="1000"),
     *              @OA\Property(property="category", type="string", example="CH20"),
     *              @OA\Property(property="title", type="string", example="null"),
     *              @OA\Property(property="created_at", type="timestamp", example="2021-05-06 09:00:00"),
     *              @OA\Property(property="updated_at", type="timestamp", example="2021-05-06 09:00:00"),
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function store()
    {
        //
    }

    /**
     * @OA\Get(
     *      path="/Player/{id}",
     *      operationId="getPlayerById",
     *      tags={"Players"},
     *      summary="Get player information",
     *      description="Returns player data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Player id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example="1"),
     *              @OA\Property(property="name", type="string", example="František Nový"),
     *              @OA\Property(property="elo", type="integer", example="1000"),
     *              @OA\Property(property="category", type="string", example="CH20"),
     *              @OA\Property(property="title", type="string", example="null"),
     *              @OA\Property(property="points", type="integer", example=9),
     *              @OA\Property(property="created_at", type="timestamp", example="2021-05-06 09:00:00"),
     *              @OA\Property(property="updated_at", type="timestamp", example="2021-05-06 09:00:00"),
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function show(User $user)
    {
        //
    }

    /**
     * @OA\Put(
     *      path="/Player/{id}",
     *      operationId="updatePlayer",
     *      tags={"Players"},
     *      summary="Overrides existing tournament values.",
     *      description="Returns updated player data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example="1"),
     *              @OA\Property(property="name", type="string", example="František Nový"),
     *              @OA\Property(property="elo", type="integer", example="1000"),
     *              @OA\Property(property="category", type="string", example="CH20"),
     *              @OA\Property(property="title", type="string", example="null"),
     *              @OA\Property(property="created_at", type="timestamp", example="2021-05-06 09:00:00"),
     *              @OA\Property(property="updated_at", type="timestamp", example="2021-05-06 09:00:00"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example="1"),
     *              @OA\Property(property="name", type="string", example="František Nový"),
     *              @OA\Property(property="elo", type="integer", example="1000"),
     *              @OA\Property(property="category", type="string", example="CH20"),
     *              @OA\Property(property="title", type="string", example="null"),
     *              @OA\Property(property="created_at", type="timestamp", example="2021-05-06 09:00:00"),
     *              @OA\Property(property="updated_at", type="timestamp", example="2021-05-06 09:00:00"),
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * @OA\Post(
     *      path="/users/checkPlayerId",
     *      operationId="checkPlayerId",
     *      tags={"Players"},
     *      summary="Check if the typed id is a valid player id.",
     *      description="Returns true if the player can attend the tournament.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Player id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="hash",
     *          description="Tournament hash",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Returns true if the player can attend the tournament.",
     *          @OA\JsonContent(
     *              @OA\Property(property="valid", type="bool", example="true")
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * )
     */
    public function checkPlayerId(string $hash)
    {
        //
    }

}