<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!file_exists(storage_path() . '/app/files/artists')){
            File::makeDirectory(storage_path() . '/app/files/artistes/');
            dd(!file_exists(storage_path() . '/app/files/artistes/'));
        }
    }
}
