<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StyleController extends Controller
{
    public function index(){
        //
    }

    public function show($slug){
        $style = DB::table('styles')->where('slug', $slug)->first();

        $artists = DB::table('artists')->where('style_id', $style->id)->orderByDesc('follow')->get();
        
        $albums = array();

        foreach($artists as $artist){
            $albums_of_artist = DB::table('albums')->where('artist_id', $artist->id)->inRandomOrder()->get();
            foreach($albums_of_artist as $unique_album){
                $albums[$unique_album->slug] = $unique_album; 
                $albums[$unique_album->slug]->artist = $artist->name; 
                $albums[$unique_album->slug]->artist_slug = $artist->slug; 

            }
            
        }

        // dd($albums);
        shuffle($albums);

        return view('style.show')->with([
            'style' => $style,
            'artists' => $artists,
            'albums' => $albums
        ]);
    }
}
