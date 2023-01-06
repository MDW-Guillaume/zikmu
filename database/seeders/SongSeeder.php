<?php

namespace Database\Seeders;

use App\Models\Song;
use App\Models\Album;
use App\Models\Style;
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

        # Récupération des artistes, albums, longueur et année de sortie
        $musical_path = scandir(public_path('music') . '/music');

        # Création d'un répertoire pour stocker les dossiers de chaque albums
        File::makeDirectory(storage_path() . '/app/files/');
        File::makeDirectory(storage_path() . '/app/files/music/');

        # Pour chaque album du répertoire original/music
        for ($i = 0; $i < count($musical_path); $i++) {
            # Si le fichier/dossier n'est pas un chemin
            if ($musical_path[$i] != "." && $musical_path[$i] != '..') {
                # transformation du nom de dossier en slug
                $folder_slug_name = Str::slug($musical_path[$i]);
                # Séparation des informations comprises dans le nom du dossier 
                $musical_explode = explode(' - ', $musical_path[$i]);
                $artist_name = $musical_explode[2];
                $artist_slug = Str::slug($musical_explode[2]);
                $album_name = $musical_explode[3];
                $album_slug = Str::slug($musical_explode[3]);
                $album_length = $musical_explode[1];
                $album_release = $musical_explode[0];
                # Création du dossier de l'album nommé par un slug 
                File::makeDirectory(storage_path() . '/app/files/music/' . $folder_slug_name);
                # Récupération des éléments compris dans le dossier de l'album $i 
                $album_content = scandir(public_path('music') . '/music/' . $musical_path[$i]);

                # Ajout de l'artiste en base de donnée si celui-ci n'existe pas 
                # et récupération de son id pour l'ajout dans la table Albums  
                Artist::firstOrCreate(
                    [
                        'name' => $artist_name,
                        'slug' => $artist_slug
                    ]
                );
                $artist_id = DB::table('artists')
                    ->select('id')
                    ->where('slug', '=', $artist_slug)
                    ->get();

                # Ajout de l'album en base de donnée si celui-ci n'existe pas 
                # Et récupération de son id pour l'ajout dans la table Song  
                Album::firstOrCreate(
                    [
                        'name' => $album_name,
                        'slug' => $album_slug,
                        'length' => $album_length,
                        'release' => $album_release,
                        'artist_id' => $artist_id[0]->id
                    ]
                );
                $album_id = DB::table('albums')
                    ->select('id')
                    ->where('slug', '=', $album_slug)
                    ->get();

                # Pour chaque titres compris dans l'album
                for ($j = 0; $j < count($album_content) - 2; $j++) {
                    if ($album_content[$j] != "." && $album_content[$j] != '..' && $album_content[$j] != 'cover.jpg') {

                        # On transforme le nom du fichier en slug
                        $file_slug_name = Str::substrReplace(Str::slug($album_content[$j]), '.', -3, 0);
                        # On copie le fichier original dans le répertoire crée précedement en le renommant par son slug
                        copy(storage_path() . '/app/original/music/' . $musical_path[$i] . '/' . $album_content[$j], storage_path() . '/app/files/music/' . $folder_slug_name . '/' . $album_content[$j]);
                        rename(storage_path() . '/app/files/music/' . $folder_slug_name . '/' . $album_content[$j], storage_path() . '/app/files/music/' . $folder_slug_name . '/' . $file_slug_name);

                        # On récupère les informations comprises dans le nom du fichier
                        $title_explode = explode(' - ', $album_content[$j]);
                        $title_position = $title_explode[0];
                        $title_name = $title_explode[1];
                        $title_slug = Str::slug($title_explode[1]);
                        # Avec le composant Mp3Info, on récupère la longueur du titre
                        $audio = new Mp3Info(storage_path() . '/app/original/music/' . $musical_path[$i] . '/' . $album_content[$j], true);
                        $title_length = intval($audio->duration);

                        # On insère les informations récupérées en base de données dans la table Song
                        Song::firstOrCreate(
                            [
                                "name" =>  $title_name,
                                "slug" => $title_slug,
                                "position" => $title_position,
                                "length" => $title_length,
                                "album_id" => $album_id[0]->id
                            ]
                        );
                    }
                }
            }
        }

        # Récupération des genres par artistes

        $style_path = scandir(public_path('music') . '/artistes');

        for ($i = 0; $i < count($style_path); $i++) {
            if ($style_path[$i] != "." && $style_path[$i] != '..') {
                $style_name = $style_path[$i];
                $style_slug = Str::slug($style_path[$i]);

                Style::firstOrCreate(
                    [
                        'name' => $style_name,
                        'slug' => $style_slug,
                    ]
                );

                $style_id = DB::table('styles')
                    ->select('id')
                    ->where('slug', '=', Str::slug($style_path[$i]))
                    ->get();

                $style_artist_path = scandir(public_path('music') . '/artistes/' . $style_name);

                for ($j = 0; $j < count($style_artist_path); $j++) {
                    if ($style_artist_path[$j] != "." && $style_artist_path[$j] != '..') {
                        $filename = pathinfo($style_artist_path[$j], PATHINFO_FILENAME);

                        DB::table('artists')->where('slug', $filename)->update(['style_id' => $style_id[0]->id, 'cover' => $style_artist_path[$j]]);
                    }
                }
            }
        }
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