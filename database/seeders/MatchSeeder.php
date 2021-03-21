<?php

namespace Database\Seeders;

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

        MatchService::generateBySwissSystem($players);
    }
}
