<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    use RefreshDatabase;

    public function test_players_have_matching_points_after_round()
    {

    }

    public function player_with_incorrect_id_cannot_participate_in_tournament()
    {

    }

}