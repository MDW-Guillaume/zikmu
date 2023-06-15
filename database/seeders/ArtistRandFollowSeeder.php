<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Artist;

class ArtistRandFollowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $all_artists = DB::table('artists')->get('id');

        foreach ($all_artists as $artist) {
            $rand_follow = rand(0, 99999);

            DB::table('artists')->where('id', $artist->id)->update(['follow' => $rand_follow]);
        }

    }
}
