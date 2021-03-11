<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="TournamentResource",
 *     description="Tournament resource",
 *     @OA\Xml(
 *         name="TournamentResource"
 *     )
 * )
 */
class TournamentResource extends JsonResource
{


    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
