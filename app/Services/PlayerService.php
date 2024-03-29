<?php

namespace App\Services;

use App\Models\Match;
use App\Models\Player;
use App\Models\User;
use Illuminate\Support\Collection;

class PlayerService
{
    public function updatePoints($round)
    {
        Match::where('round', $round)->get()
            ->each(function ($match) {

                $pointsByResult = $match->result;

                if ($pointsByResult == 1) {
                    $match->whitePlayer->update([
                        'points' => $match->whitePlayer->points + 1,
                    ]);
                } else if ($pointsByResult == 2) {
                    $match->whitePlayer->update([
                        'points' => $match->whitePlayer->points + 0.5,
                    ]);
                    $match->blackPlayer->update([
                        'points' => $match->blackPlayer->points + 0.5,
                    ]);
                } else {
                    $match->blackPlayer->update([
                        'points' => $match->blackPlayer->points + 1,
                    ]);
                }
            });
    }
}