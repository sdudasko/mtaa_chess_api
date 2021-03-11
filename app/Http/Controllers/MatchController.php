<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMatchRequest;
use App\Models\Match;
use App\Models\Player;

class MatchController extends Controller
{
    /**
     * @OA\Get(
     *      path="/matches",
     *      operationId="getMatchesList",
     *      tags={"Matches"},
     *      summary="Get list of matches",
     *      description="Returns list of matches",
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
     * )
     */
    public function index()
    {
        //

    }

    /**
     * @OA\Get(
     *      path="/matches/{id}",
     *      operationId="getPlayerMatches",
     *      tags={"Matches"},
     *      summary="Get list of player's matches. (User with id 2 in the example.)",
     *      description="Returns list of player's matches",
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
        //

    }

    /**
     * @OA\Put(
     *      path="/matches",
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
        //
    }

    /**
     * @OA\Post(
     *      path="/matches/{id}",
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
     *          required=true,
     *          in="query",
     *          @OA\Property(property="result", type="integer", example="1")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
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
     *          response=422,
     *          description="Invalid request body.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Sorry, invalid request body.")
     *      )
     *  )
     * )
     */
    public function update(UpdateMatchRequest $request, Match $match)
    {
        //
    }

    /**
     * @OA\Get(
     *      path="/matches/exportToPDF/{id}",
     *      operationId="matchesExportToPDF",
     *      tags={"Matches"},
     *      summary="Export new round to PDF",
     *      description="Stores file to the device.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Match id",
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
    public function exportToPDF(Match $match)
    {
        //
    }
}
