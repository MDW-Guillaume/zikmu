<?php

namespace Database\Factories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SongsUser>
 */
class SongsUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $song_count = count(DB::table('songs')->get());
        return [
            'user_id' => 1,
            'song_id' => fake()->numberBetween(1, $song_count)
        ];
    }
}
