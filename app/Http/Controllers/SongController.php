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

                $song_info = DB::table('songs')->where('id', $title)->select('id', 'slug', 'album_id')->first();
                $album_info = DB::table('albums')->where('id', $song_info->album_id)->select('slug', 'release', 'length' ,'artist_id')->first();
                $artist_info = DB::table('artists')->where('id', $album_info->artist_id)->select('slug')->first();

                $release = $album_info->release;
                $length = $album_info->length;
                $artist = $artist_info->slug;
                $album = $album_info->slug;
                $song_title = $song_info->slug;

                // $song_array[$song_info->id]['path'] = $release . '-' . $length . '-' . $artist . '-' . $album . '/' . $song_title;
                $song_array[] = $release . '-' . $length . '-' . $artist . '-' . $album . '/' . $song_title;
            }
        }

        return response()->json(['success' => true, 'request' => $song_array]);
    }
}
