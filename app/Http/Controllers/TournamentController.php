<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTournamentRequest;
use App\Http\Requests\UpdateTournamentRequest;
use App\Http\Resources\TournamentResource;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class TournamentController extends Controller
{
    /**
     * @OA\Put(
     *      path="/tournaments",
     *      operationId="storeTournament",
     *      tags={"Tournaments"},
     *      summary="Store new tournament",
     *      description="Returns tournament data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"title","date", "tempo"},
     *              @OA\Property(property="title", type="string", format="string", example="Tournament name"),
     *              @OA\Property(property="date", type="datetime", format="YYYY-MM-DD HH:MM:SS", example="2021-05-06 09:00:00"),
     *              @OA\Property(property="tempo", type="integer", example="3"),
     *              @OA\Property(property="tempo_minutes", type="integer", example="2"),
     *              @OA\Property(property="rounds", type="integer", example="15"),
     *              @OA\Property(property="description", type="text", example="Description"),
     *              @OA\Property(property="image", type="bytearray", example=""),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Tournament")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *       @OA\Response(
     *          response=422,
     *          description="Invalid request body.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Sorry, invalid request body.")
     *        )
     *     )
     *  )
     * )
     * @param StoreTournamentRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(Request $request)
    {
        Log::info("STORE");
        Log::info(collect($request->all())->toJson());
        $validator = Validator::make($request->all(), [
            'title'           => 'required|string',
            'date'            => 'nullable|date',
            'tempo_minutes'   => 'required|integer',
            'tempo_increment' => 'nullable|integer',
            'rounds'          => 'required|integer',
            'description'     => 'nullable|string',
            'file' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }

        $user_id=Auth::id();
        $count = Tournament::where('user_id', $user_id)->count();

        if ($count==0) {
            $sanitized = $validator->validated();
            $sanitized["user_id"] = Auth::id();
            $sanitized["qr_hash"] = $qr_hash = Str::random(20);
            $tournament = Tournament::Create($sanitized);
            $tournament->tournament_hash = $tournament->qr_hash;

            if ($request->has('file')) {

                $image = base64_decode($request->get('file'));

                Storage::disk('local')->put('turnaj.png', $image);

                $tournament->update([
                    'file_path' => "turnaj.png",
                ]);
            }

            return response()->json(['data' => $tournament], 201);
        }
        else
        {
            return response()->json("Can't create tournament for user:$user_id",422);
        }

    }

    /**
     * @OA\Get(
     *      path="/tournaments/{hash}",
     *      operationId="getTournamentByHash",
     *      tags={"Tournaments"},
     *      summary="Get tournament information",
     *      description="Returns tournament data",
     *      @OA\Parameter(
     *          name="hash",
     *          description="Tournament hash",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *           @OA\JsonContent(
     *              type="object",
     *              example={
     *                    "tournament": {
     *                          "id": 1,
     *                          "title": "Tournament",
     *                          "user_id": 2,
     *                          "tempo_minutes": 3,
     *                          "tempo_increment": 5,
     *                          "description": null,
     *                          "datetime": null,
     *                          "rounds": 9,
     *                          "file_path": "JHZ0DJZUjkoNdJjqe8M8iL0Q3mjy6nxqbsVt5PQE.jpg",
     *                          "qr_hash": "GMfVDb5vFDLGtupHGM2f",
     *                          "created_at": "2021-03-25T11:47:13.000000Z",
     *                          "updated_at": "2021-03-25T11:47:13.000000Z",
     *                      },
     *                    "file": "..."
     *             }
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      )
     * )
     */
    public function show($hash)
    {
        Log::info("SHOW");
        Log::info($hash);
        $tournament = Tournament::where('qr_hash', $hash)->first();

        if (!$tournament)
            return response('Tournament not found', 404);
        $path = storage_path("app/$tournament->file_path");

        if ($tournament->file_path)
            if (File::exists($path))
                $encoded_file = base64_encode(file_get_contents($path));
            else
                $encoded_file = null;
        else
            $encoded_file = null;

        $tournament->organiser = User::find($tournament->user_id)->name;

        return response()->json([
            'data' => $tournament,
            'file' => $encoded_file,
            'tournament_hash' => $hash,

        ], 201);

    }

    /**
     * @OA\Put(
     *      path="/tournaments/{id}",
     *      operationId="updateTournament",
     *      tags={"Tournaments"},
     *      summary="Overrides existing tournament values.",
     *      description="Returns updated tournament data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Tournament id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Tournament")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *           @OA\JsonContent(
     *              type="object",
     *              example={
     *                    "tournament": {
     *                          "id": 1,
     *                          "title": "Tournament",
     *                          "user_id": 2,
     *                          "tempo_minutes": 3,
     *                          "tempo_increment": 5,
     *                          "description": null,
     *                          "datetime": null,
     *                          "rounds": 9,
     *                          "file_path": "JHZ0DJZUjkoNdJjqe8M8iL0Q3mjy6nxqbsVt5PQE.jpg",
     *                          "qr_hash": "GMfVDb5vFDLGtupHGM2f",
     *                          "created_at": "2021-03-25T11:47:13.000000Z",
     *                          "updated_at": "2021-03-25T11:47:13.000000Z",
     *                      },
     *                    "file": "..."
     *             }
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
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Invalid request body.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Sorry, invalid request body.")
     *        )
     *     )
     * )
     * @param UpdateTournamentRequest $request
     * @param Tournament $tournament
     */
    public function update(Request $request, $hash)
    {
        Log::info("UPDATE");
        Log::info($hash);
        $validator = Validator::make($request->all(), [
            'title'           => 'nullable|string',
            'datetime'            => 'nullable|date',
            'tempo_minutes'   => 'nullable|integer',
            'tempo_increment' => 'nullable|integer',
            'rounds'          => 'nullable|integer',
            'description'     => 'nullable|string',
            'file'       => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }

        $user_id=Auth::id();
        $tournament=Tournament::where('qr_hash', $hash)->first();
        if (!$tournament)
            return response()->json("Tournament with hash $hash was not found.",404);

        $title= $request->input('title');
        $datetime=$request->input('datetime');
        $tempo_minutes=$request->input('tempo_minutes');
        $tempo_increment=$request->input('tempo_increment');
        $rounds=$request->input('rounds');
        $description=$request->input('description');


        if ($request->has('file')) {

            $image = base64_decode($request->get('file'));

            Storage::disk('local')->put('turnaj.png', $image);

            $tournament->update([
                'file_path' => "turnaj.png",
            ]);
        }

        if ($title!= null)
        {
            $tournament->update([
                'title' => "$title",
            ]);
        }
        if ($datetime!= null)
        {
            $tournament->update([
                'datetime' => "$datetime",
            ]);
        }
        if ($tempo_minutes!= null)
        {
            $tournament->update([
                'tempo_minutes' => "$tempo_minutes",
            ]);
        }
        if ($tempo_increment!= null)
        {
            $tournament->update([
                'tempo_increment' => "$tempo_increment",
            ]);
        }
        if ($rounds!= null)
        {
            $tournament->update([
                'rounds' => "$rounds",
            ]);
        }
        if ($description!= null)
        {
            $tournament->update([
                'description' => "$description",
            ]);
        }

        $tournament->tournament_hash = $hash;

        return response()->json(['data' => $tournament], 201);

    }

    /**
     * @OA\Delete(
     *      path="/tournaments/{id}",
     *      operationId="deleteTournament",
     *      tags={"Tournaments"},
     *      summary="Delete existing tournament",
     *      description="Deletes a record and returns no content.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Tournament id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function destroy(Request $request)
    {
        Log::info("DELETE");
//        return response()->json(['data' => $id], 204); // TODO - Remove to enable detete
        $user_id=Auth::id();

        $auth_id = auth()->id();

        if ($auth_id == $user_id) {
            $tournament = Tournament::where('user_id', $auth_id)->first();
            $tournament->delete();
        }

        return response()->json("Successful operation", 204);
    }

    /**
     * @OA\Post(
     *      path="/tournaments/checkTournamentByHash/{hash}",
     *      operationId="checkTournamentByHash",
     *      tags={"Tournaments"},
     *      summary="Check if the scanned hash is a valid tournament hash.",
     *      description="Returns true if the tournament is active and player can attend it.",
     *      @OA\Parameter(
     *          name="hash",
     *          description="Tournament hash",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Returns true if the provided tournament hash is valid.",
     *          @OA\JsonContent(
     *              @OA\Property(property="valid", type="bool", example="true")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     *    )
     * )
     */
    public function checkTournamentByHash(string $hash)
    {
        $count = Tournament::where('qr_hash', $hash)->count();
        if ($count==1)
        {
            return response()->json(['valid' => true]);
        }
        else
        {
            return response()->json(['valid' => false]);
        }
    }

}

