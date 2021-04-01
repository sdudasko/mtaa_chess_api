<?php

namespace Database\Seeders;

use App\Models\Match;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         User::factory(101)->create();
         User::all()->sortByDesc('id')->first()->update([
             'role_id' => 1,
         ]);

        Artisan::call('db:seed --class="TournamentSeeder"');
        Artisan::call('db:seed --class="MatchSeeder"');
    }
}
