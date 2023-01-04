<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
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
        // Copie du dossier musical vers un autre chemin

        // File::copyDirectory(storage_path() . '/app/files', storage_path() . '/app/original');
        dd(storage_path() . '/app/files');


        // Récupération des artistes, albums, longueur et année de sortie
        $musical_path = scandir(public_path('music') . '/music');
        
        $zikmu = array();
        for($i = 2; $i < count($musical_path) - 1; $i++){
            $musical_explode = explode(' - ', $musical_path[$i]);
            $zikmu[$musical_explode[2]][$musical_explode[3]]["release"] = $musical_explode[0];
            $zikmu[$musical_explode[2]][$musical_explode[3]]["length"] = $musical_explode[1];
            $zikmu[$musical_explode[2]][$musical_explode[3]]["titles"] = array();
            
            //Récupération du titre de la musique, rangé dans la colonne correspondante
            
            $album_content = scandir(public_path('music') . '/music/' . $musical_path[$i]);

            for($j = 2; $j < count($album_content) -2; $j++){
                $title_explode = explode(' - ', $album_content[$j]);
                $zikmu[$musical_explode[2]][$musical_explode[3]]["titles"][] = array("position" => $title_explode[0], "name" => $title_explode[1], "slug" => $title_explode[1]);

            }
        }
        dd($zikmu);
                


        
    }
}
