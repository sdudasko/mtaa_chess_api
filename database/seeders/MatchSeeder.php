<?php

namespace Database\Seeders;

use App\Models\Match;
use App\Models\User;
use App\Services\MatchService;
use Illuminate\Database\Seeder;

class MatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $players = User::where("role_id", null)->get();

        if (Match::all()->sortByDesc('round')->first())
            $newRoundNumber = Match::all()->sortByDesc('round')->first()->round +1;
        else
            $newRoundNumber = 1;

        MatchService::generateBySwissSystem($players, $newRoundNumber, true);
    }
}
