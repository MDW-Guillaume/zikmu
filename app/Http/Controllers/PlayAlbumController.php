<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\SongsQueue;

class PlayAlbumController extends Controller
{
    public function fastPlayAlbum(Request $request)
    {
        $album_id_request = $request->album_id;

        // Récupération des titres de l'album choisi sous forme de tableau
        $get_album_titles = DB::table('songs')->where('album_id', $album_id_request)->get();

        // Récupération de l'id de l'utilisateur
        $user_id = Auth::user();

        // Ajout des titres dans la table file d'attente song_queue
        $position = 0;
        foreach ($get_album_titles as $title_id) {
            SongsQueue::firstOrCreate(
                [
                    'user_id' => $user_id->id,
                    'song_id' => $title_id->id,
                    'position' => $position,
                    ]
            );
            $position++;
        }

        // Récupération de la position de départ
        $position = $request->position;

        // Récupération du son en fontion de la position de la file d'attente
        $song_position_id = DB::table('songs_queues')->where(['user_id' => $user_id->id, 'position' => $position])->select('song_id')->first();

        // Récuération des informations relatives au son et création d'une URL à renvoyer en JSON
        $get_song_information = DB::table('songs')->where('id', $song_position_id->song_id)->select('slug', 'name', 'album_id')->first();
        $get_album_information = DB::table('albums')->where('id', $get_song_information->album_id)->select('slug', 'release', 'length', 'name', 'artist_id')->first();
        $get_artist_information = DB::table('artists')->where('id', $get_album_information->artist_id)->select('slug', 'name')->first();

        $release = $get_album_information->release;
        $length = $get_album_information->length;
        $artist_slug = $get_artist_information->slug;
        $artist_name = $get_artist_information->name;
        $album_slug = $get_album_information->slug;
        $album_name = $get_album_information->name;
        $song_slug = $get_song_information->slug;
        $song_name = $get_song_information->name;

        $song_url = '/storage/files/music/' . $release . '-' . $length . '-' . $artist_slug . '-' . $album_slug . '/' . $song_slug;

        return response()->json(['success' => true, 'position' => $position, 'song_url' => $song_url, 'song_name' => $song_name, 'album_name' => $album_name, 'artist_name' => $artist_name]);
    }

    public function playNextSong(Request $request){
        $user_id = Auth::user();

        $position = $request->position;

        // Récupération du son en fontion de la position de la file d'attente
        $song_position_id = DB::table('songs_queues')->where(['user_id' => $user_id->id, 'position' => $position])->select('song_id')->first();

        // Récuération des informations relatives au son et création d'une URL à renvoyer en JSON
        $get_song_information = DB::table('songs')->where('id', $song_position_id->song_id)->select('slug', 'name', 'album_id')->first();
        $get_album_information = DB::table('albums')->where('id', $get_song_information->album_id)->select('slug', 'release', 'length', 'name', 'artist_id')->first();
        $get_artist_information = DB::table('artists')->where('id', $get_album_information->artist_id)->select('slug', 'name')->first();

        $release = $get_album_information->release;
        $length = $get_album_information->length;
        $artist_slug = $get_artist_information->slug;
        $artist_name = $get_artist_information->name;
        $album_slug = $get_album_information->slug;
        $album_name = $get_album_information->name;
        $song_slug = $get_song_information->slug;
        $song_name = $get_song_information->name;

        $song_url = '/storage/files/music/' . $release . '-' . $length . '-' . $artist_slug . '-' . $album_slug . '/' . $song_slug;

        return response()->json(['success' => true, 'position' => $position, 'song_url' => $song_url, 'song_name' => $song_name, 'album_name' => $album_name, 'artist_name' => $artist_name]);
    }
}
