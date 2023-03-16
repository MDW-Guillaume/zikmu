<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $my_user_favorite_songs = DB::table('songs_users')->where('user_id', $user->id)->select('id', 'song_id')->get();

        $user_favorite_array = array();
        $i = 0;
        $length = 0;

        foreach ($my_user_favorite_songs as $my_user_favorite_song) {
            $i++;
            $song_table = DB::table('songs')->where('id', $my_user_favorite_song->song_id)->first();

            $user_favorite_array[$i] = $song_table;

            $album = DB::table('albums')->where('id', $song_table->album_id)->first();
            // dd($album);

            $user_favorite_array[$i]->album_name = $album->name;
            $user_favorite_array[$i]->album_slug = $album->slug;
            $user_favorite_array[$i]->album_cover = $album->cover;

            $artist = DB::table('artists')->where('id', $album->artist_id)->first();

            $user_favorite_array[$i]->artist_name = $artist->name;
            $user_favorite_array[$i]->artist_slug = $artist->slug;

            if (!is_null($artist->style_id)) {
                $style = DB::table('styles')->where('id', $artist->style_id)->first();

                $user_favorite_array[$i]->style_slug = $style->slug;
            } else {
                $user_favorite_array[$i]->style_slug = null;
            }
        }

        foreach ($user_favorite_array as $song) {
            $length += $song->length;
            // dd($length);
        }
        if ($length > 3600) {
            $length = intdiv($length, 3600) . 'h ' . ($length % 3600) . 'min';
        } else {
            $length = ($length % 60) . 'min';
        }
        // dd($user_favorite_array);

        return view('favorite.index')->with([
            'user' => $user,
            'songs' => $user_favorite_array,
            'length' => $length,
        ]);
    }

}
