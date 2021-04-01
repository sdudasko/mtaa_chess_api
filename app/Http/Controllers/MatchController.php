<?php

namespace App\Http\Controllers;

use App\Models\Match;
use App\Models\Tournament;
use App\Models\User;
use App\Services\MatchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade as PDF;

class MatchController extends Controller
{
    /**
     * @OA\Get(
     *      path="/matches/{tournamentId}",
     *      operationId="getMatchesList",
     *      tags={"Matches"},
     *      summary="Get list of matches",
     *      description="Returns list of matches",
     *      @OA\Parameter(
     *          name="hash",
     *          description="Tournament hash",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="round",
     *          description="Round number",
     *          required=false,
     *          in="query",
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
     *                          "white": 3,
     *                          "black": 8,
     *                          "result": null,
     *                          "round": 5,
     *                          "table": 1,
     *                          "created_at": "2021-03-25T11:47:13.000000Z",
     *                          "updated_at": "2021-03-25T11:47:13.000000Z",
     *                      },
     *                    1: {
     *                          "id": 2,
     *                          "white": 4,
     *                          "black": 9,
     *                          "result": 1,
     *                          "round": 5,
     *                          "table": 2,
     *                          "created_at": "2021-03-25T11:47:13.000000Z",
     *                          "updated_at": "2021-03-25T11:47:13.000000Z",
     *                     },
     *                    2: {
     *                          "id": 3,
     *                          "table": 3,
     *                          "white": 5,
     *                          "black": 10,
     *                          "result": 2,
     *                          "round": 5,
     *                          "table": 3,
     *                          "created_at": "2021-03-25T11:47:13.000000Z",
     *                          "updated_at": "2021-03-25T11:47:13.000000Z",
     *                    },
     *                    3: {
     *                          "id": 4,
     *                          "table": 4,
     *                          "white": 6,
     *                          "black": 11,
     *                          "result": 0,
     *                          "round": 5,
     *                          "table": 4,
     *                          "created_at": "2021-03-25T11:47:13.000000Z",
     *                          "updated_at": "2021-03-25T11:47:13.000000Z",
     *                    },
     *             }
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     * )
     */
    public function index(Request $request)
    {
        $sanitized = Validator::make($request->all(), [
            'hash' => 'required',
            'round' => 'nullable|integer',
        ])->validated();

        $tournament = Tournament::where('qr_hash', $sanitized['hash'])->first();

        if (isset($sanitized['round']) && $sanitized['round']) {
            $matches = $tournament->matches()->where('round', $sanitized['round'])->get();
        } else {
            $matches = $tournament->matches;
        }

        return response()->json($matches, 201);
    }

    /**
     * @OA\Put(
     *      path="/matches/{tournamentId}",
     *      operationId="storeMatch",
     *      tags={"Matches"},
     *      summary="Create new round",
     *      description="Returns new round data",
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *           @OA\JsonContent(
     *              type="object",
     *              example={
     *                    0: {
     *                          "table": 1,
     *                          "white": 3,
     *                          "black": 8,
     *                          "result": null,
     *                          "round": 5,
     *                      },
     *                    1: {
     *                          "table": 2,
     *                          "white": 4,
     *                          "black": 9,
     *                          "result": 1,
     *                          "round": 5,
     *                     },
     *                    2: {
     *                          "table": 3,
     *                          "white": 5,
     *                          "black": 10,
     *                          "result": 2,
     *                          "round": 5,
     *                    },
     *                    3: {
     *                          "table": 4,
     *                          "white": 6,
     *                          "black": 11,
     *                          "result": 0,
     *                          "round": 5,
     *                    },
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
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function store()
    {
        $administrator = auth()->user();

        $tournament = $administrator->tournament;
        if (!$tournament) {
            return response()->json('There is not tournament created for this user', 403);
        }

        $players = User::where("role_id", null)->where('tournament_id', $tournament->id)->get();

        $lastRoundMatches = $tournament->matches;

        $foundMatchInProgress = $lastRoundMatches->first(function ($match) {
            return is_null($match->result);
        }, false);


        if ($foundMatchInProgress != null) {
            return response()->json(["Matches are still in progress"], 403);
        }

        if ($lastRoundMatches->count() != 0)
            $lastRound = $lastRoundMatches->sortByDesc('round')->first()->round;
        else
            $lastRound = 0;

        $generatedMatches = MatchService::generateBySwissSystem($players, $lastRound + 1, $tournament);

        return response()->json($generatedMatches, 201);
    }

    /**
     * @OA\Post(
     *      path="/matches/{id}/{tournamentId}",
     *      operationId="updateMatch",
     *      tags={"Matches"},
     *      summary="Update existing match",
     *      description="Returns updated match data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Match id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="result",
     *          description="Match result",
     *          required=false,
     *          in="query",
     *          @OA\Property(property="result", type="integer", example="1")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Invalid request body.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Sorry, invalid request body.")
     *      )
     *  )
     * )
     */
    public function update(Request $request, Match $match)
    {
        $validator = Validator::make($request->all(), [
            'result' => ['required', 'integer', Rule::in([0, 1, 2])],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $sanitized = $validator->validated();

        $matchService = (new MatchService());
        $match->update($sanitized);

        $match->blackPlayer->update([
            'points' => $matchService->getPointsByResult($sanitized['result']),
        ]);
        $match->whitePlayer->update([
            'points' => $matchService->getPointsByResult($sanitized['result']),
        ]);

        return response()->json([], 200);

    }

    /**
     * @OA\Get(
     *      path="/matches/exportToPDF/{round}",
     *      operationId="matchesExportToPDF",
     *      tags={"Matches"},
     *      summary="Export new round to PDF",
     *      description="Stores file to the device.",
     *      @OA\Parameter(
     *          name="round",
     *          description="Round",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function exportToPDF($round)
    {
        $matches = Match::where('round', $round)->get();

        $pdf = PDF::loadView('pdf.match',
            [
                'matches' => $matches,
                'round'   => $round,
            ]);

        return $pdf->download('match.pdf');
    }
}
