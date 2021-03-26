<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Models\Player;
use App\Models\User;
use App\Services\PlayerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
     *                          "email": "carter.cheyenne@example.com",
     *                          "email_verified_at": "2021-03-25T11:47:13.000000Z",
     *                          "created_at": "2021-03-25T11:47:13.000000Z",
     *                          "updated_at": "2021-03-25T11:47:13.000000Z",
     *                          "role_id": "null",
     *                          "elo": 2650,
     *                          "category": "CH24",
     *                          "title": "GM",
     *                          "points": "0"
     *                      },
     *                    1: {
     *                          "id": 2,
     *                          "name": "František Starý",
     *                          "email": "carter.cheyenne@example.com",
     *                          "email_verified_at": "2021-03-25T11:47:13.000000Z",
     *                          "created_at": "2021-03-25T11:47:13.000000Z",
     *                          "updated_at": "2021-03-25T11:47:13.000000Z",
     *                          "role_id": "null",
     *                          "elo": 2600,
     *                          "category": "CH24",
     *                          "title": "GM",
     *                          "points": "0"
     *                     },
     *                    2: {
     *                          "id": 3,
     *                          "name": "Samuel Halčin",
     *                          "email": "carter.cheyenne@example.com",
     *                          "email_verified_at": "2021-03-25T11:47:13.000000Z",
     *                          "created_at": "2021-03-25T11:47:13.000000Z",
     *                          "updated_at": "2021-03-25T11:47:13.000000Z",
     *                          "role_id": "null",
     *                          "elo": 2477,
     *                          "category": "CH18",
     *                          "title": "IM",
     *                          "points": "0"
     *                    },
     *                    3: {
     *                          "id": 3,
     *                          "name": "Anna Lizáková",
     *                          "email": "carter.cheyenne@example.com",
     *                          "email_verified_at": "2021-03-25T11:47:13.000000Z",
     *                          "created_at": "2021-03-25T11:47:13.000000Z",
     *                          "updated_at": "2021-03-25T11:47:13.000000Z",
     *                          "role_id": "null",
     *                          "elo": 2311,
     *                          "category": "D18",
     *                          "title": "FM",
     *                          "points": "0"
     *                    },
     *             }
     *          )
     *       ),
     *     )
     */

    public function index()
    {
        $users = User::where('role_id', null)->get();

        return response()->json($users, 201);
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
     * @OA\Put(
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
     *              @OA\Property(property="category", type="string", example="CH18"),
     *              @OA\Property(property="title", type="string", example=NULL),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example="1"),
     *              @OA\Property(property="name", type="string", example="František Nový"),
     *              @OA\Property(property="elo", type="integer", example="1000"),
     *              @OA\Property(property="category", type="string", example="CH18"),
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string',
            'elo'      => 'required|integer',
            'category' => ['required', 'string', Rule::in(Category::getCategories())],
            'title'    => ['nullable', 'string', Rule::in(['FM', 'WGM', 'WFM', 'WIM', 'CM', 'IM', 'GM'])],
            'email'    => 'email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $sanitized = $validator->validated();

        $newUser = User::create($sanitized);

        return $newUser;
    }

    /**
     * @OA\Get(
     *      path="/players/{id}",
     *      operationId="getPlayerById",
     *      tags={"Players"},
     *      summary="Get player information",
     *      description="Returns player data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Player id",
     *          required=true,
     *          in="path",
     *          example=1,
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
     *              @OA\Property(property="email", type="string", example="example@gmail.com"),
     *              @OA\Property(property="email_verified_at", type="string", example="2021-03-25T17:31:07.000000Z"),
     *              @OA\Property(property="created_at", type="timestamp", example="2021-05-06 09:00:00"),
     *              @OA\Property(property="updated_at", type="timestamp", example="2021-05-06 09:00:00"),
     *              @OA\Property(property="role_id", type="integer", example=NULL),
     *              @OA\Property(property="elo", type="integer", example="1000"),
     *              @OA\Property(property="category", type="string", example="CH20"),
     *              @OA\Property(property="title", type="string", example="null"),
     *              @OA\Property(property="points", type="integer", example=9),
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
    public function show(Player $player)
    {
        return response()->json($player, 201);
    }

    /**
     * @OA\Put(
     *      path="/players/{id}",
     *      operationId="updatePlayer",
     *      tags={"Players"},
     *      summary="Overrides existing player values.",
     *      description="Returns updated player data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Player id",
     *          required=true,
     *          in="path",
     *          example=1,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="František Nový"),
     *              @OA\Property(property="elo", type="integer", example="1000"),
     *              @OA\Property(property="category", type="string", example="CH18"),
     *              @OA\Property(property="title", type="string", example="GM"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example="1"),
     *              @OA\Property(property="name", type="string", example="František Nový"),
     *              @OA\Property(property="elo", type="integer", example="1000"),
     *              @OA\Property(property="category", type="string", example="CH18"),
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
    public function update(Request $request, Player $player)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'nullable|string',
            'elo'      => 'nullable|integer',
            'category' => ['nullable', 'string', Rule::in(Category::getCategories())],
            'title'    => ['nullable', 'string', Rule::in(['FM', 'WGM', 'WFM', 'WIM', 'CM', 'IM', 'GM'])],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $sanitized = $validator->validated();

        $player->update($sanitized);

        return response()->json($player, 201);
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

    /**
     * @OA\Get(
     *      path="/players/{id}/matches",
     *      operationId="getPlayerMatches",
     *      tags={"Players"},
     *      summary="Get list of player's matches. (User with id 2 in the example.)",
     *      description="Returns list of player's matches",
     *      @OA\Parameter(
     *          name="id",
     *          description="Player id",
     *          required=true,
     *          in="path",
     *          example=1,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *           @OA\JsonContent(
     *              type="object",
     *              example={
     *                    0: {
     *                          "table": 1,
     *                          "white": 2,
     *                          "black": 8,
     *                          "result": 3,
     *                          "round": 1,
     *                      },
     *                    1: {
     *                          "table": 2,
     *                          "white": 9,
     *                          "black": 2,
     *                          "result": 1,
     *                          "round": 2,
     *                     },
     *                    2: {
     *                          "table": 3,
     *                          "white": 2,
     *                          "black": 10,
     *                          "result": 2,
     *                          "round": 3,
     *                    },
     *                    3: {
     *                          "table": 4,
     *                          "white": 11,
     *                          "black": 2,
     *                          "result": 0,
     *                          "round": 4,
     *                    },
     *             }
     *          )
     *       ),
     *     )
     */
    public function getPlayerGames(Player $player)
    {
        $matches = $player->matchesCustom();

        return response()->json($matches, 201);
    }
}