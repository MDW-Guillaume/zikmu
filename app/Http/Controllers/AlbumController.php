<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlbumController extends Controller
{
    public function index(){
        //
    }

    public function show($slug){

        $album = DB::table('albums')->where('slug', $slug)->first();
        $titles = DB::table('songs')->where('album_id', $album->id)->get();
        $artist = DB::table('artists')->select('name', 'slug', 'style_id')->where('id', $album->artist_id)->first();
        $style = DB::table('styles')->select('name', 'slug')->where('id', $artist->style_id)->first();
        // dd($album, $titles, $artist, $style);
        if($album->length > 60){
        $length = intdiv($album->length, 60). 'h '. ($album->length % 60).'min';
        }else{
            $length = $album->length . 'min';
        }
        return view('album.show', [
            'album' => $album,
            'titles' => $titles,
            'artist' => $artist,
            'style' => $style,
            'length' => $length
        ]);


    }
}
