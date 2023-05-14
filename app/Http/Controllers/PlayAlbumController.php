<?php

namespace App\Http\Controllers;

use App\Models\Song;
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

        // Regénération de la file d'attente
        SongsQueue::where('user_id', $user_id->id)->delete();

        // Ajout des titres dans la table file d'attente song_queue
        foreach ($get_album_titles as $title_id) {
            SongsQueue::firstOrCreate(
                [
                    'user_id' => $user_id->id,
                    'song_id' => $title_id->id,
                    'position' => $title_id->position,
                ]
            );
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

    public function playNextSong(Request $request)
    {
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

    public function playAlbumElement(Request $request)
    {
        // Récupération des informations de l'utilisateur
        $user = Auth::user();
        // Récupération de l'ID du son cliqué
        $song_id = $request->song_id;

        // Récupération des informations nécessaires du son (position, slug, album_id)
        $song_info = DB::table('songs')->where('id', $song_id)->select('album_id', 'position', 'slug', 'name')->first();

        // Récupération de tous les titres de l'album
        $all_album_songs = DB::table('songs')->where('album_id', $song_info->album_id)->get();

        // On clear les sons déja en file d'attente pour l'utilisateur
        SongsQueue::where('user_id', $user->id)->delete();

        // Ajout des titres dans la table file d'attente song_queue
        foreach ($all_album_songs as $album_song) {
            SongsQueue::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'song_id' => $album_song->id,
                    'position' => $album_song->position,
                ]
            );
        }

        // Récupération des informations nécessaires de l'album à partir du son
        $album_info = DB::table('albums')->where('id', $song_info->album_id)->select('artist_id', 'slug', 'length', 'release', 'name', 'cover')->first();

        // Récupération des informations nécessaires de l'artiste à partir de l'album
        $artist_info = DB::table('artists')->where('id', $album_info->artist_id)->select('slug', 'name')->first();

        $release = $album_info->release;
        $length = $album_info->length;
        $artist_slug = $artist_info->slug;
        $artist_name = $artist_info->name;
        $album_slug = $album_info->slug;
        $album_name = $album_info->name;
        $album_cover = $album_info->cover;
        $song_slug = $song_info->slug;
        $song_name = $song_info->name;

        if ($album_cover) {
            $cover_url = '/storage/files/albums/' . $artist_slug . '/' . $album_cover;
        } else {
            $cover_url = '/img/unknown_cover.png';
        }
        $song_url = '/storage/files/music/' . $release . '-' . $length . '-' . $artist_slug . '-' . $album_slug . '/' . $song_slug;

        return response()->json(['success' => true, 'position' => $song_info->position, 'song_url' => $song_url, 'cover_url' => $cover_url, 'song_name' => $song_name, 'album_name' => $album_name, 'artist_name' => $artist_name]);
    }

    public function playFavoriteElement(Request $request)
    {
        // Récupération des informations de l'utilisateur
        $user = Auth::user();
        // Récupération de l'ID du son cliqué
        $song_id = $request->song_id;

        // Récupération de tous les favoris de l'utilisateur
        $all_favorite_songs = DB::table('songs_users')->where('user_id', $user->id)->get();
        // On clear les sons déja en file d'attente pour l'utilisateur
        SongsQueue::where('user_id', $user->id)->delete();

        // Ajout des titres dans la table file d'attente song_queue
        $table_song_position = 1;
        foreach ($all_favorite_songs as $favorite_song) {
            SongsQueue::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'song_id' => $favorite_song->song_id,
                    'position' => $table_song_position,
                    ]
                );
                $table_song_position++;
        }

        // Récupération de la position du son cliqué
        $song_clicked_position = DB::table('songs_queues')->where('song_id', $song_id)->select('position')->first();

        // Récupération des informations nécessaires du son (position, slug, album_id)
        $song_info = DB::table('songs')->where('id', $song_id)->select('album_id', 'slug', 'name')->first();

        // Récupération des informations nécessaires de l'album à partir du son
        $album_info = DB::table('albums')->where('id', $song_info->album_id)->select('artist_id', 'slug', 'length', 'release', 'name', 'cover')->first();

        // Récupération des informations nécessaires de l'artiste à partir de l'album
        $artist_info = DB::table('artists')->where('id', $album_info->artist_id)->select('slug', 'name')->first();

        $release = $album_info->release;
        $length = $album_info->length;
        $artist_slug = $artist_info->slug;
        $artist_name = $artist_info->name;
        $album_slug = $album_info->slug;
        $album_name = $album_info->name;
        $album_cover = $album_info->cover;
        $song_slug = $song_info->slug;
        $song_name = $song_info->name;

        if ($album_cover) {
            $cover_url = '/storage/files/albums/' . $artist_slug . '/' . $album_cover;
        } else {
            $cover_url = '/img/unknown_cover.png';
        }
        $song_url = '/storage/files/music/' . $release . '-' . $length . '-' . $artist_slug . '-' . $album_slug . '/' . $song_slug;

        return response()->json(['success' => true, 'position' => $song_clicked_position->position, 'song_url' => $song_url, 'cover_url' => $cover_url, 'song_name' => $song_name, 'album_name' => $album_name, 'artist_name' => $artist_name]);
    }
}
