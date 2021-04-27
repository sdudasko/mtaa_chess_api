<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Imports\PlayersImport;
use App\Imports\TransactionsImport;
use App\Models\Category;
use App\Models\Player;
use App\Models\Tournament;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *      path="/players/tournament/{tournamentId}",
     *      operationId="getPlayersList",
     *      tags={"Players"},
     *      summary="Get list of players",
     *      description="Returns list of players",
     *      @OA\Parameter(
     *          name="tournamentId",
     *          required=false,
     *          in="path",
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

    public function index($tournamentId)
    {
        $users = User::where('role_id', null)
            ->where('tournament_id', $tournamentId)
            ->orderBy('id')
            ->get();

        return response()->json(['data' => $users], 201);
    }

    /**
     * @OA\Post(
     *      path="/players/import/storeBulk",
     *      operationId="storeBulkPlayers",
     *      tags={"Players"},
     *      summary="Store list of players",
     *      description="Returns whether operation was successful.",
     *      @OA\RequestBody(
     *      required=true,
     *      description="Bulk players Body",
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="players",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="first_name", type="string"),
     *                      @OA\Property(property="last_name", type="string"),
     *                      @OA\Property(property="email", type="string"),
     *                      @OA\Property(property="phone", type="string"),
     *                  )
     *              )
     *          )
     *      )
     *   ),
     *       @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *       @OA\Response(
     *          response=422,
     *          description="Invalid request.",
     *       ),
     *     )
     */
    public function storeBulk(Request $request)
    {
        $administrator = User::where('id', auth()->id())->first();

        if (!$administrator->tournament) {
            return response()->json('There is not tournament created for this user', 403);
        }

        try {
            Excel::import(new PlayersImport($administrator->tournament), $request->import_file);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 422);
        }

        \Session::put('success', 'Your file is imported successfully in database.');

        return response()->json([], 200);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function importExportView()
    {
        return view('excel.index');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function importExcel(Request $request)
    {
        \Excel::import(new TransactionsImport, $request->import_file);

        \Session::put('success', 'Your file is imported successfully in database.');

        return back();
    }

    /**
     * @OA\Get(
     *      path="/standings/{hash}/{?round}",
     *      operationId="getStandings",
     *      tags={"Standings"},
     *      summary="Get standings",
     *      @OA\Parameter(
     *          name="hash",
     *          required=true,
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
    public function standings(Request $request,$tournament_id)
    {

        $validator = Validator::make($request->all(), [
            'category' => ['nullable', 'string', Rule::in(Category::getCategories())],
        ]);

        $sanitized = $validator->validated();
        $category= $request->input('category');

        if($category!=null){
            $standings=User::where('tournament_id', $tournament_id)->where('category',$sanitized['category'])->orderByRaw('points DESC')->get();
        }
        else if($category==null){
            $standings=User::where('tournament_id', $tournament_id)->orderByRaw('points DESC')->get();
        }

        return response()->json($standings, 201);
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
        $administrator = User::find(auth()->id());
        $tournament = $administrator->tournament;

        if (!$tournament) {
            return response()->json('There is not tournament created for this user', 403);
        }

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string',
            'elo'      => 'required|integer',
//            'category' => ['required', 'string', Rule::in(Category::getCategories())],
//            'title'    => ['nullable', 'string', Rule::in(['FM', 'WGM', 'WFM', 'WIM', 'CM', 'IM', 'GM'])],
            'category' => ['required', 'string'],
            'title'    => ['nullable', 'string'],
            'email'    => 'email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $sanitized = $validator->validated();

        $newUser = User::create($sanitized);
        $newUser->update([
            'tournament_id' => $tournament->id,
            'registration_id' => Str::random(8),
        ]);

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
        return response()->json(['data' => $player], 201);
    }

    /**
     * @OA\Put(
     *      path="/players/{id}",
     *      operationId="updatePlayer",
     *      tags={"Players"},
     *      summary="Updates existing player values.",
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
//            'category' => ['nullable', 'string', Rule::in(Category::getCategories())],
//            'title'    => ['nullable', 'string', Rule::in(['FM', 'WGM', 'WFM', 'WIM', 'CM', 'IM', 'GM'])],
            'category' => ['nullable', 'string'],
            'title'    => ['nullable', 'string'],
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
     *      path="/players/checkPlayerId",
     *      operationId="checkPlayerId",
     *      tags={"Players"},
     *      summary="Check if the typed id is a valid player id.",
     *      description="Returns true if the player can attend the tournament.",
     *      @OA\Parameter(
     *          name="registration_id",
     *          description="Given id",
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
     *          response=200,
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
    public function checkPlayerId(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hash'     => 'required|string|exists:tournaments,qr_hash',
            'registration_id'     => 'required|string|exists:users,registration_id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 403);
        }

        $sanitized = $validator->validated();

        return response()->json(['message' => "User exists"], 200);
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
    public function getPlayerGames($registration_id)
    {
        $player = Player::where('registration_id', $registration_id)->first();
        if (!$player)
            return response()->json('Player not found', 404);

        $matches = $player->matchesCustom();

        $playersAll = User::all();

        $matches->each(function($match) use ($playersAll) {
            $match->whiteName = $playersAll->where('id', $match->white)->first()->name;
            $match->blackName = $playersAll->where('id', $match->black)->first()->name;
        });

        $winPercentage = $player->points / $matches->whereNotNull('result')->count();

        $nextMatch = $matches->whereNull('result')->first();

        if (!$nextMatch) {
            $opponentName = "";
            $nextRoundTable = "";
            $time = "";
        } else {
            if ($nextMatch->white == $player->id) {
                $opponentName = $nextMatch->blackName;
            } else {
                $opponentName = $nextMatch->whiteName;
            }
            $nextRoundTable = $nextMatch->table;
            $time = "10:00";
        }


        $incrementElo = $player->points >= 1 ? rand(1, 20) : rand(-1, -20);

        return response()->json([
            'data' => $matches,
            'winPercentage' => $winPercentage * 100,
            'opponentName' => $opponentName,
            'elo' => $player->elo,
            'eloIncrement' => "$incrementElo",
            'nextRoundTable' => $nextRoundTable,
            'time' => $time,
            'tournament_name' => Tournament::where('id', $player->tournament_id)->first()->title,
            'file' => Tournament::where('id', $player->tournament_id)->first()->file
        ], 201);
    }

    public function destroy(Request $request, $id)
    {


        User::where('id', $id)->delete();

        return response()->json(['code' => 204], 204);
    }
}
