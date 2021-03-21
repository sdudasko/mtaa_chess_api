<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Player",
 *     description="Player model",
 * )
 */
class Player extends User
{

    public function matches()
    {
        return $this->belongsToMany(Match::class);
    }
}
