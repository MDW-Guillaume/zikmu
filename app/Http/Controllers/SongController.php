<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SongController extends Controller
{
    public function listenPlaylist(Request $request)
    {

        $favorite_titles = $request->input();
        foreach ($favorite_titles as $title) {
            if (preg_match('/^[0-9]+$/', $title)) {
                // Renvoie le slug du chemin pour les titres
                $song_info = DB::table('songs')->where('id', $title)->select('id', 'slug', 'album_id')->first();
                $album_info = DB::table('albums')->where('id', $song_info->album_id)->select('slug', 'release', 'length', 'artist_id')->first();
                $artist_info = DB::table('artists')->where('id', $album_info->artist_id)->select('slug')->first();

                $release = $album_info->release;
                $length = $album_info->length;
                $artist = $artist_info->slug;
                $album = $album_info->slug;
                $song_title = $song_info->slug;


                $song_array[] = $release . '-' . $length . '-' . $artist . '-' . $album . '/' . $song_title;

                // Renvoie le chemin avec les espaces mais a voir pourquoi je ne peux pas accéder a mon symbolic link

                // $song_info = DB::table('songs')->where('id', $title)->select('id', 'name', 'position', 'slug', 'album_id')->first();
                // $album_info = DB::table('albums')->where('id', $song_info->album_id)->select('name', 'slug', 'release', 'length', 'artist_id')->first();
                // $artist_info = DB::table('artists')->where('id', $album_info->artist_id)->select('name', 'slug')->first();

                // if($song_info->position < 10){
                //     $song_position = '0' . $song_info->position;
                // }else{
                //     $song_position = $song_info->position;
                // }
                // $release = $album_info->release;
                // $length = $album_info->length;
                // $artist = $artist_info->name;
                // $album = $album_info->name;
                // $song_title = $song_info->name;
                // $song_array[] = $release . ' - ' . $length . ' - ' . $artist . ' - ' . $album . '/' . $song_position . ' - ' . $song_title . '.mp3';
            }
        }

        return response()->json(['success' => true, 'request' => $song_array]);
    }
}
