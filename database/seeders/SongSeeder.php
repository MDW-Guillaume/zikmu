<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Support\Str;
use wapmorgan\Mp3Info\Mp3Info;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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

        for ($i = 0; $i < 4; $i++) {
            if ($musical_path[$i] != "." && $musical_path[$i] != '..') {
                $folder_slug_name = Str::slug($musical_path[$i]);
                $musical_explode = explode(' - ', $musical_path[$i]);
                $album_content = scandir(public_path('music') . '/music/' . $musical_path[$i]);

                Artist::firstOrCreate(
                    [
                        'name' => $musical_explode[2],
                        'slug' => Str::slug($musical_explode[2])
                    ]
                );
                $artist_id = DB::table('artists')
                          ->select('id')
                          ->where('slug', '=', Str::slug($musical_explode[2]))
                          ->get();
                dd($artist_id);
                Album::firstOrCreate(
                    [
                        'name' => $musical_explode[3],
                        'slug' => Str::slug($musical_explode[3]),
                        'length' => $musical_explode[1],
                        'release' => $musical_explode[0],
                        'artist_id' => $artist_id->id
                    ]
                    );



                for ($j = 0; $j < count($album_content) - 2; $j++) {
                    if ($musical_path[$i] != "." && $musical_path[$i] != '..' && $musical_path[$i] != 'cover.jpg') {
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
        dd($zikmu["artistes"]);
    }
}





#  Récupération des artistes, albums, longueur et année de sortie
// $musical_path = scandir(public_path('music') . '/music');

// $zikmu = array();
// File::makeDirectory(storage_path() . '/app/files');
// for ($i = 2; $i < count($musical_path) - 1; $i++) {
//     $folder_slug_name = Str::slug($musical_path[$i]);
//     File::makeDirectory(storage_path() . '/app/files/' . $folder_slug_name);
//     $musical_explode = explode(' - ', $musical_path[$i]);
//     $zikmu[$musical_explode[2]][$musical_explode[3]]["release"] = $musical_explode[0];
//     $zikmu[$musical_explode[2]][$musical_explode[3]]["length"] = $musical_explode[1];
//     $zikmu[$musical_explode[2]][$musical_explode[3]]["titles"] = array();

//     # Récupération du titre de la musique, rangé dans la colonne correspondante
//     $album_content = scandir(public_path('music') . '/music/' . $musical_path[$i]);

//     for ($j = 2; $j < count($album_content) - 2; $j++) {
//         $file_slug_name = Str::substrReplace(Str::slug($album_content[$j]), '.', -3, 0);
//         // dd(file_exists(storage_path() . '/app/original/music/' . $musical_path[$i] . '/' . $album_content[$j]));
//         copy(storage_path() . '/app/original/music/' . $musical_path[$i] . '/' . $album_content[$j], storage_path() . '/app/files/' . $folder_slug_name . '/' . $album_content[$j]);
//         rename(storage_path() . '/app/files/' . $folder_slug_name . '/' . $album_content[$j], storage_path() . '/app/files/' . $folder_slug_name . '/' . $file_slug_name);
//         $title_explode = explode(' - ', $album_content[$j]);
//         $zikmu[$musical_explode[2]][$musical_explode[3]]["titles"][] = array("position" => $title_explode[0], "name" => $title_explode[1], "slug" => $file_slug_name);

//         $audio = new Mp3Info(storage_path() . '/app/original/music/' . $musical_path[$i] . '/' . $album_content[$j], true);
//         $title_length = $audio->duration; 
//     }
// }

// foreach ($zikmu as $artist => $artist_content) {
//     dd($artist);
//     Artist::firstOrCreate(
//         ["name" => $artist],
//         // ["cover" => ]
//     );
// }