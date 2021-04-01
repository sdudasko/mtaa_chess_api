<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TournamentTest extends TestCase
{
    use RefreshDatabase;

    public function test_organizer_can_create_tournament()
    {
        $administrator = User::where('role_id', 1)->first();
        $this->actingAs($administrator, 'api');

        $param=[];

        $param['title']='title';
        $param['tempo_minutes']='3';



        $response = $this->call('put', "v1/tournaments",  $param);

        $this->assertTrue(true);
    }

}
