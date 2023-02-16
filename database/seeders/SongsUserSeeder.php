<?php

namespace Database\Seeders;

use App\Models\SongsUser;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SongsUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SongsUser::factory()->count(50)->create();
    }
}
