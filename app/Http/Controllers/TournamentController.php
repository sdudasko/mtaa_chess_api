<?php

namespace App\Http\Controllers;

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
}