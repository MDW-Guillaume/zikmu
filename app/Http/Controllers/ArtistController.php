<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArtistController extends Controller
{
    public function index(){
        //
    }

    public function show($slug){
        $artist_info = DB::table('artists')->where('slug', $slug)->first();

        $artist_style= DB::table('styles')->select('slug')->where('id', $artist_info->style_id)->first();

        $albums = DB::table('albums')->where('artist_id', $artist_info->id)->get();
        
        // dd($artist_info, $artist_style, $albums)

        return view('artist.show')->with([
            'artist' => $artist_info,
            'style' => $artist_style,
            'albums' => $albums,
        ]);
    }
}
