<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Tournament",
 *     description="Tournament model",
 *     @OA\Xml(
 *         name="Tournament"
 *     )
 * )
 */
class Tournament extends Model
{
    use HasFactory;
}
