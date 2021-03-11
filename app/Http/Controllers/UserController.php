<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTournamentRequest;
use App\Http\Resources\TournamentResource;
use App\Models\Tournament;

class TournamentController extends Controller
{
    /**
     * @OA\Get(
     *      path="/players",
     *      operationId="getPlayersList",
     *      tags={"Players"},
     *      summary="Get list of players",
     *      description="Returns list of players",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/UserResource")
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
        return new  UserResource(User::all());
    }
	
	
	 /**
     * @OA\Get(
     *      path="/standings",
     *      operationId="getStandings",
     *      tags={"Standings"},
     *      summary="Get standings",
     *      description="Returns standings",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/UserResource")
     *       ),
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
     *          @OA\JsonContent(ref="#/components/schemas/StorePlayerRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Player")
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
     *      path="/Player/{id}",
     *      operationId="getPlayerById",
     *      tags={"Player"},
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
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Player")
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
    public function show(User $user)
    {
        //
    }
	    /**
     * @OA\Get(
     *      path="/Player/edit/{id}",
     *      operationId="editPlayerById",
     *      tags={"Player"},
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
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Player")
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
    public function edit(User $user)
    {
        //
    }

    /**
     * @OA\Put(
     *      path="/Player/{id}",
     *      operationId="updatePlayer",
     *      tags={"Player"},
     *      summary="Update existing player",
     *      description="Returns updated player data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Player id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdatePlayerRequest")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Player")
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
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

}