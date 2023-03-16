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
        # Le public path 'music' renvoie vers storage/app

        # Analyse des fichiers de musique dans le dossier music-20s
        $musical_path = scandir(public_path('music') . '/music-20s');

        # Création d'un répertoire pour formater le nom des dossiers par le slug
        if (!is_dir(public_path('music') . '/public')) {
            File::makeDirectory(public_path('music') . '/public');

            File::makeDirectory(public_path('storage') . '/files');
            File::makeDirectory(public_path('storage') . '/files/music');
        }

        # Pour chaque album du répertoire /music-20s
        for ($i = 0; $i < count($musical_path); $i++) {
            # Si le fichier/dossier n'est pas un chemin
            if ($musical_path[$i] != "." && $musical_path[$i] != '..' && $musical_path[$i] != '.DS_Store') {

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
                if (!is_dir(public_path('storage') . '/files/music/' . $folder_slug_name)) {
                    File::makeDirectory(public_path('storage') . '/files/music/' . $folder_slug_name);
                }

                # Récupération des éléments compris dans le dossier de l'album $i
                $album_content = scandir(public_path('music') . '/music-20s/' . $musical_path[$i]);

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
                    if ($album_content[$j] != "." && $album_content[$j] != '..' && $album_content[$j] != '.DS_Store' && $album_content[$j] != 'cover.jpg') {

                        # On récupère les informations comprises dans le nom du fichier
                        $title_explode = explode(' - ', $album_content[$j]);
                        $title_position = $title_explode[0];
                        $title_info = pathinfo($title_explode[1]);
                        $title_name = $title_info['filename'];

                        # On transforme le nom du fichier en slug
                        $pathinfo_extention_length = strlen(pathinfo($title_explode[1], PATHINFO_EXTENSION));
                        $slug_filename = Str::substrReplace(Str::slug($title_explode[1]), '.', -$pathinfo_extention_length, 0);

                        # Avec le composant Mp3Info, on récupère la longueur du titre
                        $audio = new Mp3Info(public_path('music') . '/music-20s/' . $musical_path[$i] . '/' . $album_content[$j], true);
                        $title_length = intval($audio->duration);

                        # On copie le fichier original dans le répertoire crée précedement en le renommant par son slug
                        copy(public_path('music') . '/music-20s/' . $musical_path[$i] . '/' . $album_content[$j], public_path('storage') . '/files/music/' . $folder_slug_name . '/' . $album_content[$j]);
                        rename(public_path('storage') . '/files/music/' . $folder_slug_name . '/' . $album_content[$j], public_path('storage') . '/files/music/' . $folder_slug_name . '/' . $slug_filename);

                        # On insère les informations récupérées en base de données dans la table Song
                        Song::firstOrCreate(
                            [
                                "name" =>  $title_name,
                                "slug" => $slug_filename,
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

        # On crée le dossier si celui ci n'existe pas déjà
        if (!is_dir(public_path('storage') . '/files/artistes')) {
            File::makeDirectory(public_path('storage') . '/files/artistes');
        }

        for ($i = 0; $i < count($style_path); $i++) {
            if ($style_path[$i] != "." && $style_path[$i] != '..' && $style_path[$i] != '.DS_Store') {

                # Stockage et formatage des informations des dossiers dans des variables
                $style_name = $style_path[$i];
                $style_slug = Str::slug($style_path[$i]);

                # Création du dossier du genre actuel
                if (!file_exists(public_path('storage') . '/files/artistes/' . $style_slug)) {
                    File::makeDirectory(public_path('storage') . '/files/artistes/' . $style_slug);
                }

                # Ajout du style en base de données
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

                # Parcours de chaque dossier de genre
                for ($j = 0; $j < count($style_artist_path); $j++) {
                    if ($style_artist_path[$j] != "." && $style_artist_path[$j] != '..' && $style_artist_path[$j] != '.DS_Store') {

                        # Récupération du nom de fichier pour le transformer en slug.
                        # Stockage du nom du fichier avec son extention, et ce peut importe la longueur de celle-ci.
                        $filename = pathinfo($style_artist_path[$j], PATHINFO_FILENAME);
                        $pathinfo_extention_length = strlen(pathinfo($style_artist_path[$j], PATHINFO_EXTENSION));
                        $slug_filename = Str::substrReplace(Str::slug($style_artist_path[$j]), '.', -$pathinfo_extention_length, 0);

                        # Copie du fichier du dossier original vers le dossier crée par nos soins
                        if (!file_exists(public_path('storage') . '/files/artistes/' . $style_slug . '/' . $style_artist_path[$j])) {
                            copy(public_path('music') . '/artistes/' . $style_path[$i] . '/' . $style_artist_path[$j], public_path('storage') . '/files/artistes/' . $style_slug . '/' . $style_artist_path[$j]);
                            rename(public_path('storage') . '/files/artistes/' . $style_slug . '/' . $style_artist_path[$j], public_path('storage') . '/files/artistes/' . $style_slug . '/' . $slug_filename);
                        }

                        # Update du style de chaque artiste ainsi que du nom du fichier de leur cover
                        DB::table('artists')->where('slug', $filename)->update(['style_id' => $style_id[0]->id, 'cover' => $slug_filename]);
                    }
                }
            }
        }

        # Récupération des cover d'albums
        $album_path = scandir(public_path('music') . '/albums');

        # Création du dossier de cover d'albums
        if (!file_exists(public_path('storage') . '/files/albums')) {
            File::makeDirectory(public_path('storage') . '/files/albums/');
        }
        for ($i = 0; $i < count($album_path); $i++) {
            if ($album_path[$i] != "." && $album_path[$i] != '..' && $album_path[$i] != '.DS_Store') {
                $artist_form_album_path = $album_path[$i];
                $artist_slug_form_album_path = Str::slug($album_path[$i]);

                # Création du dossier du genre actuel
                if (!file_exists(public_path('storage') . '/files/albums/' . $artist_slug_form_album_path)) {
                    File::makeDirectory(public_path('storage') . '/files/albums/' . $artist_slug_form_album_path);
                }

                $artist_album_path = scandir(public_path('music') . '/albums/' . $artist_form_album_path);

                for ($j = 0; $j < count($artist_album_path); $j++) {
                    if ($artist_album_path[$j] != "." && $artist_album_path[$j] != '..' && $artist_album_path[$j] != '.DS_Store') {
                        $album_cover = $artist_album_path[$j];
                        $slug_album_no_ext = pathinfo($artist_album_path[$j], PATHINFO_FILENAME);

                        $pathinfo_extention_length = strlen(pathinfo($album_cover, PATHINFO_EXTENSION));
                        $slug_filename = Str::substrReplace(Str::slug($album_cover), '.', -$pathinfo_extention_length, 0);

                        # Copie et renommage du fichier dans un format slug
                        if (!file_exists(public_path('storage') . '/files/albums/' . $artist_slug_form_album_path . '/' . $slug_filename)) {
                            copy(public_path('music') . '/albums/' . $artist_form_album_path . '/' . $album_cover, public_path('storage') . '/files/albums/' . $artist_slug_form_album_path . '/' . $album_cover);
                            rename(public_path('storage') . '/files/albums/' . $artist_slug_form_album_path . '/' . $album_cover, public_path('storage') . '/files/albums/' . $artist_slug_form_album_path . '/' . $slug_filename);
                        }


                        $id_artist = DB::table('artists')->select('id')->where('slug', '=', $artist_form_album_path)->get();

                        DB::table('albums')->where('slug', $slug_album_no_ext)->update(['cover' => $slug_filename]);
                    }
                }
            }
        }
    }
}
