<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="UserResource",
 *     description="User resource",
 *     @OA\Xml(
 *         name="UserResource"
 *     )
 * )
 */
class UserResource extends JsonResource
{


    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
