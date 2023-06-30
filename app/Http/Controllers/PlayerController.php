<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    public function index(){
        return redirect('/');
    }

    public function show(Request $request){
        if($request->position === null){
            return response()->json([
                'success' => true,
                'redirect' => 1,
                'url' => "/home"
                ]);
        }

        $position = $request->position;

        $user_id = Auth::user();


        if ($request->status == 'random') {
            // Récupération du son en fontion de la position de la file d'attente
            $song_position_id = DB::table('songs_queues')->where(['user_id' => $user_id->id, 'random_position' => $position])->select('song_id')->first();
        } else {
            // Récupération du son en fontion de la position de la file d'attente
            $song_position_id = DB::table('songs_queues')->where(['user_id' => $user_id->id, 'position' => $position])->select('song_id')->first();
        }

        if ($song_position_id) {
            // Récuération des informations relatives au son et création d'une URL à renvoyer en JSON
            $get_song_information = DB::table('songs')->where('id', $song_position_id->song_id)->select('slug', 'name', 'album_id')->first();
            // $get_album_information = DB::table('albums')->where('id', $get_song_information->album_id)->select('slug', 'release', 'length', 'name', 'artist_id')->first();
            $get_album_information = DB::table('albums')->where('id', $get_song_information->album_id)->select('artist_id', 'slug', 'length', 'release', 'name', 'cover')->first();
            $get_artist_information = DB::table('artists')->where('id', $get_album_information->artist_id)->select('slug', 'name')->first();
            $is_song_favorite = DB::table('songs_users')->where('user_id', $user_id->id)->where('song_id', $song_position_id->song_id)->exists();

            $release = $get_album_information->release;
            $length = $get_album_information->length;
            $artist_slug = $get_artist_information->slug;
            $artist_name = $get_artist_information->name;
            $album_slug = $get_album_information->slug;
            $album_name = $get_album_information->name;
            $album_cover = $get_album_information->cover;
            $song_slug = $get_song_information->slug;
            $song_name = $get_song_information->name;
            $song_id = $song_position_id->song_id;

            if ($album_cover) {
                $cover_url = '/origin/public/files/music/' . $artist_slug . '/' . $album_slug . '/' . $album_cover;
            } else {
                $cover_url = '/img/unknown_cover.png';
            }

            $song_url = '/origin/public/files/music/' . $artist_slug . '/' . $album_slug . '/' . $song_slug;

            $view = view('player.show')->render();
            return response()->json(['success' => true, 'data' => $view, 'position' => $position, 'song_id' => $song_id, 'song_url' => $song_url, 'cover_url' => $cover_url,  'song_name' => $song_name, 'is_favorite' => $is_song_favorite, 'album_name' => $album_name, 'artist_name' => $artist_name, 'album_slug' => $album_slug, 'artist_slug' => $artist_slug]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
