<?php

namespace App\Services;

use App\Models\Match;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Support\Collection;

class MatchService
{
    public static function generateBySwissSystem($players, $round, $tournament, $updatePoints = false)
    {
        $numberOfPlayers = $players->count();

        $players->sortBy(function ($player) {
            return $player->points;
        });

        $j = 0;
        for ( $i = 0; $i < $numberOfPlayers; $i += 2 ) {

            if ($j % 2 == 1) {
                $match = Match::create([
                    'black' => $players->get($j)->id,
                    'white' => $players->get($numberOfPlayers / 2 + $j)->id,
                    'tournament_id' => $tournament->id,
                ]);
            } else {
                $match = Match::create([
                    'white' => $players->get($j)->id,
                    'black' => $players->get($numberOfPlayers / 2 + $j)->id,
                    'tournament_id' => $tournament->id,
                ]);
            }
            $match->update([
                'result' => $updatePoints ? collect([0, 1, 2])->random() : null,
                'round'  => $round,
                'table'  => round(($i + 1) / 2),
            ]);
            $j++;
        }

        if ($updatePoints) {
            app(PlayerService::class)->updatePoints($round);
        }

        $matchesForRound = $tournament->matches()->where('round', $round)->get();

        return $matchesForRound;
    }

    public function getPointsByResult($result)
    {
        if ($result == 1) {
            return 1;
        } else if ($result == 2) {
            return 0.5;
        } else {
            return 0;
        }
    }

}
