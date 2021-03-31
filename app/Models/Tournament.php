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
 *     ),
 *     @OA\Property(property="title", type="string", format="string", example="Tournament name"),
 *     @OA\Property(property="date", type="datetime", format="YYYY-MM-DD HH:MM:SS", example="2021-05-06 09:00:00"),
 *     @OA\Property(property="tempo", type="integer", example="3"),
 *     @OA\Property(property="tempo_increment", type="integer", example="2"),
 *     @OA\Property(property="rounds", type="integer", example="15"),
 *     @OA\Property(property="description", type="text", example="Description"),
 *     @OA\Property(property="image", type="bytearray", example=""),
 *     @OA\Property(property="qr_hash", type="string", example=""),
 *     @OA\Property(property="created_at", type="timestamp", example="2021-05-06 09:00:00"),
 *     @OA\Property(property="updated_at", type="timestamp", example="2021-05-06 09:00:00"),
 * )
 */
class Tournament extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'user_id',
        'datetime',
        'tempo_minutes',
        'tempo_increment',
        'rounds',
        'description',
        'qr_hash'
    ];
}
