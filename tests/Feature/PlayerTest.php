<?php

namespace Tests\Feature;

use App\Models\Tournament;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_player_with_incorrect_id_cannot_participate_in_tournament()
    {
        Artisan::call('db:seed');

        $registration_id = Str::random(8);
        $hash = Str::random(12);

        $response = $this->call('post', 'v1/players/checkPlayerId', [
            'hash'            => $hash,
            'registration_id' => $registration_id,
        ]);

        $response->assertStatus(403);
    }

}