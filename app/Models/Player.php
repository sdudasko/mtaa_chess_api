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
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'elo',
        'title',
        'category',
        'points',
    ];

    public function matchesCustom()
    {
        return Match::where('black', $this->id)->orWhere('white', $this->id)->get();
    }
}
