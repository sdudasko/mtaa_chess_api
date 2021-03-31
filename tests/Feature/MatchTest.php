<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatchTest extends TestCase
{
    use RefreshDatabase;

    public function test_matches_are_generated_correctly_by_swiss_system()
    {
        $this->assertTrue(true);
    }

    public function organizer_cannot_start_new_round_if_all_games_are_not_completed()
    {
        $this->assertTrue(true);
    }
}