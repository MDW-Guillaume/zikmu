<?php

namespace Database\Seeders;

use App\Models\Artist;
use Illuminate\Support\Str;
use wapmorgan\Mp3Info\Mp3Info;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        #  Récupération des artistes, albums, longueur et année de sortie
        $musical_path = scandir(public_path('music') . '/music');

        $zikmu = array();
        $zikmu_element = array();

        for ($i = 2; $i < 4; $i++) {
            if ($musical_path[$i] != "." && $musical_path[$i] != '..') {
                $folder_slug_name = Str::slug($musical_path[$i]);
                $musical_explode = explode(' - ', $musical_path[$i]);
                $album_content = scandir(public_path('music') . '/music/' . $musical_path[$i]);

                for ($j = 2; $j < count($album_content) - 2; $j++) {
                    if ($musical_path[$i] != "." && $musical_path[$i] != '..') {
                        $title_explode = explode(' - ', $album_content[$j]);
                        $audio = new Mp3Info(storage_path() . '/app/original/music/' . $musical_path[$i] . '/' . $album_content[$j], true);
                        $title_length = intval($audio->duration); 

                        $zikmu_element = [
                            "artistes" => [
                                "nom" => $musical_explode[2],
                                "slug" => Str::slug($musical_explode[2]),
                                "albums" => [
                                    "nom" => $musical_explode[3],
                                    "slug" => Str::slug($musical_explode[3]),
                                    "release" => $musical_explode[0],
                                    "length" => $musical_explode[1],
                                    "titres" => [
                                        "name" => $title_explode[1], 
                                        "slug" => Str::slug($title_explode[1]),
                                        "position" => $title_explode[0], 
                                        "length" => $title_length
                                    ]
                                ]
                            ]
                        ];
                        array_push($zikmu, $zikmu_element);
                    }
                }
            }
        }
        dd($zikmu);
    }
}
