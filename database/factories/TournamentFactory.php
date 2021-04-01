<?php

namespace Database\Factories;

use App\Models\Tournament;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TournamentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tournament::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $administrator = User::where('role_id', 1)->first();
        return [
            'title' => 'Test',
            'tempo_minutes' => 3,
            'tempo_increment' => 5,
            'description' => 'description',
            'rounds' => 9,
            'user_id' => $administrator->id,
        ];
    }
}
