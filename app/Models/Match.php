<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Match",
 *     description="Match model",
 *     @OA\Xml(
 *         name="Match"
 *     )
 * )
 */
class Match extends Model
{
    use HasFactory;
}
