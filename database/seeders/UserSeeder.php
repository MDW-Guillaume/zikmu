<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(
            ['name' => 'Guillaume',
            'email' => 'guillaume.couvidou@live.fr',
            'password' => bcrypt('Guillaume2784')
        ]);
    }
}
