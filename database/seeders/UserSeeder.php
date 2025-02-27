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
        $user = User::firstOrCreate(
            ['email' => 'guillaume.couvidou@live.fr'],
            [
                'password' => bcrypt('Guillaume2784'),
                'is_admin' => true,
                'seeder' => true
            ]
        );
    }
}
