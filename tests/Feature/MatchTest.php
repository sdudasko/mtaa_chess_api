<?php

namespace Tests\Feature;

use App\Models\Match;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\MatchService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MatchTest extends TestCase
{
    use RefreshDatabase;

    public function test_matches_are_generated_correctly_by_swiss_system()
    {
        $rounds = random_int(1, 15);

        $matchService = new MatchService();
        $players = User::factory(100)->create();


        for ($i = 1; $i < $rounds; $i++)
        {
            $matchService->generateBySwissSystem($players, $i, true);
        }

        $sumPoints = User::all()->sum(function($user) {
            return $user->points;
        });

        $total = ($rounds - 1) * $players->count()/2;

        $this->assertEquals($sumPoints, $total);
        $this->assertTrue(true);
    }

    public function organizer_cannot_start_new_round_if_all_games_are_not_completed()
    {
        $this->assertTrue(true);
    }
}