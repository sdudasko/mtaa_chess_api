<?php

namespace Tests\Feature;

use App\Models\Tournament;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\Cast\Int_;
use Tests\TestCase;

class TournamentTest extends TestCase
{
    use RefreshDatabase;

    public function test_organizer_can_create_tournament()
    {
        Artisan::call('db:seed');
        DB::table('tournaments')->truncate();

        $administrator = User::where('role_id', 1)->first();
        $this->actingAs($administrator, 'api');


        $param = [];

        $param['title'] = Str::random(5);
        $param['tempo_minutes'] = 5;
        $response = $this->call('put', "v1/tournaments", $param);
        $response->assertStatus(422);

        $param['rounds'] = 13;
        $response = $this->call('put', "v1/tournaments", $param);
        $response->assertStatus(201);

        $this->assertDatabaseHas('tournaments', [
            'title'         => $param['title'],
            'tempo_minutes' => $param['tempo_minutes'],
        ]);

        $this->assertTrue(true);
    }
}
