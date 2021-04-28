<?php

namespace Tests\Feature;

use App\Models\Match;
use App\Models\Tournament;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\MatchService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;


class MatchTest extends TestCase
{
    use RefreshDatabase;

    public function test_completed_matches_points_in_total_have_right_points()
    {
        Artisan::call('db:seed');

        $rounds = random_int(3, 15);

        $matchService = new MatchService();

        $players = User::factory(100)->create();

        for ( $i = 1; $i < $rounds - 1; $i++ ) {
            $matchService->generateBySwissSystem($players, $i, Tournament::first(), true);
        }

        $sumPoints = User::where('role_id', null)->get()->sum(function ($user) {
            return $user->points;
        });

        $total = ($rounds) * $players->count() / 2;

        $this->assertEquals($sumPoints, $total);

        $tournamentId = Tournament::first()->id;

        $response = $this->call('get', "v1/players/standings/$tournamentId");

        $data = collect(json_decode($response->content()));

        $shouldBeTotal = $data->count() - 1; // -1 for admin
        $sumAfterEndOfTournament = $data->pluck('points')->sum(function ($point) {
            return $point;
        });

        $this->assertEquals($shouldBeTotal, $sumAfterEndOfTournament);

        $response->assertStatus(201);
    }

    public function test_matches_are_generated_correctly_by_swiss_system()
    {
        $whitePlayersIds = Match::all()->groupBy('white')->keys();
        $carryNumber = Match::count();

        $i = 1;
        $ok = true;
        $whitePlayersIds->each(function ($whitePlayerId) use (&$i, &$ok, $carryNumber) {

            if ($whitePlayerId != $i) {
                $ok = false;
            }
            if ($i % 2 == 1) {
                $i += $carryNumber + 1;
            } else {
                $i -= $carryNumber;
                $i += 1;
            }
        });
        $this->assertTrue($ok);

        Artisan::call('db:seed');

        $administrator = User::where('role_id', 1)->first();

        $this->actingAs($administrator, 'api');

        $response = $this->put("v1/matches");

        $response->assertStatus(201);

    }

    public function test_organizer_cannot_start_new_round_if_all_games_are_not_completed()
    {
        Artisan::call('db:seed');

        $administrator = User::where('role_id', 1)->first();
        $this->actingAs($administrator, 'api');
        $tournament_id = Tournament::first()->id;

        $response = $this->put("v1/matches/");
        $response->assertStatus(201);

        $response = $this->put("v1/matches/");
        $response->assertStatus(403);

        $this->assertTrue(true);
    }
}
