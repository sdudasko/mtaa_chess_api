<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTournamentRequest;
use App\Http\Requests\UpdateTournamentRequest;
use App\Http\Resources\TournamentResource;
use App\Models\Tournament;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
     *              @OA\Property(property="tempo_increment", type="integer", example="2"),
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

    public function store(StoreTournamentRequest $request)
    {
        $sanitized = $request->validated();

        $tournament = Tournament::create($sanitized);

        $tournament->update([
            'qr_hash' => Str::random(40)
        ]);

        return response()->json($tournament, 201);
    }

    /**
     * @OA\Get(
     *      path="/tournaments/{id}",
     *      operationId="getTournamentById",
     *      tags={"Tournaments"},
     *      summary="Get tournament information",
     *      description="Returns tournament data",
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
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Tournament")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function show(Tournament $tournament)
    {
        //
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
    public function update(UpdateTournamentRequest $request, Tournament $tournament)
    {
        //
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
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function destroy(Tournament $tournament)
    {
        //
    }

    /**
     * @OA\Get(
     *      path="/tournaments/{hash}",
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
        //
    }

}