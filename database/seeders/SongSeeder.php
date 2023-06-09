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
        $musical_path = scandir(public_path('origin') . '/music-20s');

        $artists = [];

        // Récupération des artistes et de toutes les informations relatives
        foreach ($musical_path as $artist_album) {
            if ($artist_album != "." && $artist_album != '..' && $artist_album != '.DS_Store') {
                $musical_explode = explode(' - ', $artist_album);

                $artist = $musical_explode[2];
                $artist_slug = Str::slug($artist);
                $albums = [];
                $album = $musical_explode[3];
                $album_slug = Str::slug($album);

                if (!isset($artists[$artist])) {
                    $artists[$artist] = [
                        'slug' => $artist_slug,
                        'albums' => [],
                    ];
                }

                if (!isset($artists[$artist]['albums'][$album])) {
                    $artists[$artist]['albums'][$album] = [
                        'slug' => $album_slug,
                        'release' => $musical_explode[0],
                        'length' => $musical_explode[1],
                    ];
                }

                $songs = scandir(public_path('origin') . '/music-20s/' . $artist_album);
                $songs = array_diff($songs, ['.', '..', '.DS_Store']);

                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];

                // Filtrer les fichiers musicaux uniquement (ignorer les dossiers "." et "..")
                usort($songs, function ($a, $b) {
                    $pattern = '/\d+/'; // Expression régulière pour extraire le numéro de titre
                    preg_match($pattern, $a, $aMatches);
                    preg_match($pattern, $b, $bMatches);

                    $aNumber = isset($aMatches[0]) ? intval($aMatches[0]) : 0;
                    $bNumber = isset($bMatches[0]) ? intval($bMatches[0]) : 0;

                    return $aNumber - $bNumber;
                });

                foreach ($songs as $song) {

                    if ($song != "." && $song != '..' && $song != '.DS_Store' && count($songs) != 0) {
                        $extension = pathinfo($song, PATHINFO_EXTENSION);
                        if (!in_array(strtolower($extension), $imageExtensions)) {

                            $audio = new Mp3Info(public_path('origin') . '/music-20s/' . $artist_album . '/' . $song, true);
                            $song_length = intval($audio->duration);

                            $song_explode = explode(' - ', $song);
                            $song_position = $song_explode[0];
                            $song_name = pathinfo($song_explode[1], PATHINFO_FILENAME);
                            $song_slug = preg_replace('/[^a-z0-9]+/', '-', strtolower(pathinfo($song_name, PATHINFO_FILENAME)));

                            if (!isset($artists[$artist]['albums'][$album]['songs'][$song_name])) {
                                $artists[$artist]['albums'][$album]['songs'][$song_name] = [
                                    'slug' => $song_slug . '.' . $extension,
                                    'position' => $song_position,
                                    'length' => $song_length,
                                    'initial_name' => $song
                                ];
                            }
                        } else {
                            if (!isset($artists[$artist]['albums'][$album]['cover'])) {
                                $artists[$artist]['albums'][$album]['cover'] = $song;
                            }
                        }
                    }
                }
            }
        }

        $all_styles_path = scandir(public_path('origin') . '/artistes');

        // Récupération des styles pour chaque artistes
        foreach ($all_styles_path as $style) {
            if ($style != "." && $style != '..' && $style != '.DS_Store') {
                $style_slug = Str::slug($style);
                $style_path = scandir(public_path('origin') . '/artistes/' . $style);
                if (!isset($styles[$style])) {
                    $styles[$style] = [
                        'slug' => $style_slug,
                        'artists' => [],
                    ];
                }
                foreach ($style_path as $style_content) {
                    if ($style_content != "." && $style_content != '..' && $style_content != '.DS_Store') {
                        $artist_slug = pathinfo($style_content, PATHINFO_FILENAME);
                        if (!isset($styles[$style]['artist'][$artist_slug])) {
                            $styles[$style]['artists'][$artist_slug] = $style_content;
                        }
                    }
                }
            }
        }




        // Insertion en base de données et création des fichiers dans le dossier public
        if (!is_dir(public_path('origin') . '/public')) {
            File::makeDirectory(public_path('origin') . '/public');

            File::makeDirectory(public_path('origin') . '/public/files');
            File::makeDirectory(public_path('origin') . '/public/files/music');

        }

        foreach ($artists as $artist => $artist_content) {
            $current_artist = Artist::firstOrCreate(
                [
                    'name' => $artist,
                    'slug' => $artist_content['slug']
                ]
            );

            $artist_id = $current_artist->id;

            if (!is_dir(public_path('origin') . '/public/files/music/' . $artist_content['slug'])) {
                File::makeDirectory(public_path('origin') . '/public/files/music/' . $artist_content['slug']);
            }

            foreach ($artist_content['albums'] as $album => $album_content) {
                $current_album = Album::firstOrCreate(
                    [
                        'name' => $album,
                        'slug' => $album_content['slug'],
                        'cover' => $album_content['cover'],
                        'length' => $album_content['length'],
                        'release' => $album_content['release'],
                        'artist_id' => $artist_id
                    ]
                );

                $album_id = $current_album->id;

                $initial_path = $album_content['release'] . ' - ' . $album_content['length'] . ' - ' . $artist . ' - ' . $album;
                if (!is_dir(public_path('origin') . '/public/files/music/' . $artist_content['slug'] . '/' . $album_content['slug'])) {
                    File::makeDirectory(public_path('origin') . '/public/files/music/' . $artist_content['slug'] . '/' . $album_content['slug']);
                }

                if (
                    file_exists(public_path('origin') . '/music-20s/' . $initial_path . '/' . $album_content['cover'])
                    &&
                    !file_exists(public_path('origin') . '/public/files/music/' . $artist_content['slug'] . '/' . $album_content['slug'] . '/' . $album_content['cover'])
                ) {
                    copy(
                        public_path('origin') . '/music-20s/' . $initial_path . '/' . $album_content['cover'],
                        public_path('origin') . '/public/files/music/' . $artist_content['slug'] . '/' . $album_content['slug'] . '/' . $album_content['cover']
                    );
                }

                if (isset($album_content['songs'])) {
                    foreach ($album_content['songs'] as $song => $song_content) {
                        Song::firstOrCreate(
                            [
                                "name" =>  $song,
                                "slug" => $song_content['slug'],
                                "position" => $song_content['position'],
                                "length" => $song_content['length'],
                                "album_id" => $album_id
                            ]
                        );

                        # On copie le fichier original dans le répertoire crée précedement en le renommant par son slug
                        if (
                            file_exists(public_path('origin') . '/music-20s/' . $initial_path . '/' . $song_content['initial_name'])
                            &&
                            !file_exists(public_path('origin') . '/public/files/music/' . $artist_content['slug'] . '/' . $album_content['slug'] . '/' . $song_content['slug'])
                        ) {
                            copy(
                                public_path('origin') . '/music-20s/' . $initial_path . '/' . $song_content['initial_name'],
                                public_path('origin') . '/public/files/music/' . $artist_content['slug'] . '/' . $album_content['slug'] . '/' . $song_content['slug']
                            );
                        }

                        if (
                            file_exists(public_path('origin') . '/music-20s/' . $initial_path . '/' . $song_content['initial_name'])
                            &&
                            !file_exists(public_path('origin') . '/public/files/music/' . $artist_content['slug'] . '/' . $album_content['slug'] . '/' . $song_content['slug'])
                        ) {
                            copy(
                                public_path('origin') . '/music-20s/' . $initial_path . '/' . $song_content['initial_name'],
                                public_path('origin') . '/public/files/music/' . $artist_content['slug'] . '/' . $album_content['slug'] . '/' . $song_content['slug']
                            );
                        }
                    }
                }
            }
        }

        foreach ($styles as $style => $style_content) {
            $current_style = Style::firstOrCreate(
                [
                    'name' => $style,
                    'slug' => $style_content['slug'],
                ]
            );

            $style_id = $current_style->id;
            foreach ($style_content['artists'] as $artist_slug => $cover) {
                $artist = Artist::where('slug', $artist_slug)->first();
                if ($artist) {
                    $artist->style_id = $style_id; // Remplacez $style_id par la valeur à assigner à la colonne style_id
                    $artist->cover = $cover; // Remplacez $style_id par la valeur à assigner à la colonne style_id
                    $artist->save();
                    if (
                        file_exists(public_path('origin') . '/artistes/' . $style . '/' . $artist->cover)
                        &&
                        !file_exists(public_path('origin') . '/public/files/music/' . $artist->slug . '/' . $artist->cover)
                    ) {
                        copy(
                            public_path('origin') . '/artistes/' . $style . '/' . $artist->cover,
                            public_path('origin') . '/public/files/music/' . $artist->slug . '/' . $artist->cover
                        );
                    }
                }
            }
        }
    }
}
