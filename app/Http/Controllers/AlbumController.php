<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    public function index()
    {
        //
    }

    public function show($slug)
    {

        $album = DB::table('albums')->where('slug', $slug)->first();
        $artist = DB::table('artists')->select('name', 'slug', 'style_id')->where('id', $album->artist_id)->first();
        $style = DB::table('styles')->select('name', 'slug')->where('id', $artist->style_id)->first();
        // dd($album, $titles, $artist, $style);
        if ($album->length > 60) {
            $length = intdiv($album->length, 60) . 'h ' . ($album->length % 60) . 'min';
        } else {
            $length = $album->length . 'min';
        }

        $album_titles = DB::table('songs')->where('album_id', $album->id)->get();
        $favorites = DB::table('songs_users')->where('user_id', Auth::user()->id)->select('song_id')->get();

        $favorites = DB::table('songs_users')->where('user_id', Auth::user()->id)->select('song_id')->get();
        $favorites_album = DB::table('albums_users')->where('user_id', Auth::user()->id)->select('album_id')->get();



        foreach ($album_titles as $album_title) {
            $album_title->favorite = false;
            foreach ($favorites as $favorite) {
                // dd($album_title->id, $favorite->song_id);
                if ($album_title->id == $favorite->song_id) {
                    $album_title->favorite = true;
                }
            }
            foreach ($favorites_album as $favorite_album) {
                if ($album->id == $favorite_album->album_id) {
                    $album->favorite = true;
                }
            }
        }

        if($album->cover){

            if (file_exists(public_path('storage') . '/files/music/' . $artist->slug . '/' . $album->slug . '/' . $album->cover)) {
                $album->cover = '/storage/files/music/' . $artist->slug . '/' . $album->slug . '/' . $album->cover;
            }else{
                $album->cover = 'undefined.jpg';
            }
        }else{
            $album->cover = 'undefined.jpg';
        }



        // dd($artist, $album_titles, $style);
        // die;

        // dd($album_titles, $favorites);
        return view('album.show', [
            'album' => $album,
            'titles' => $album_titles,
            'artist' => $artist,
            'style' => $style,
            'length' => $length
        ]);
    }
}
