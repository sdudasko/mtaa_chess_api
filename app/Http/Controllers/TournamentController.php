<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTournamentRequest;
use App\Http\Resources\TournamentResource;
use App\Models\Tournament;

class TournamentController extends Controller
{
    /**
     * @OA\Get(
     *      path="/tournaments",
     *      operationId="getTournamentsList",
     *      tags={"Tournaments"},
     *      summary="Get list of tournaments",
     *      description="Returns list of tournaments",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TournamentResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index()
    {
        return new TournamentResource(Tournament::all());

    }

    /**
     * @OA\Post(
     *      path="/tournaments",
     *      operationId="storeTournament",
     *      tags={"Tournaments"},
     *      summary="Store new tournament",
     *      description="Returns tournament data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreTournamentRequest")
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
     *      )
     * )
     */
    public function store()
    {
        //
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
     *          response=200,
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
     *      summary="Update existing tournament",
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
     *          @OA\JsonContent(ref="#/components/schemas/UpdateTournamentRequest")
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
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
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
     *      description="Deletes a record and returns no content",
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
     *          @OA\JsonContent()
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
}