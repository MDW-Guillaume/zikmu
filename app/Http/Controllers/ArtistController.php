<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ArtistController extends Controller
{
    public function index()
    {
        $artists = DB::table('artists')->get();


        foreach ($artists as $artist) {
            if (!is_null($artist->style_id)) {
                $artist_style = DB::table('styles')->where('id', $artist->style_id)->first();
                $artist->style = $artist_style->slug;
                if(!is_null($artist->cover)){
                $artist->cover = '/origin/public/files/music/' . $artist->slug . '/' . $artist->cover;
            }else{
                $artist->cover = '/img/unknow.png';
            }}
        }

        return view('artist.index')->with([
            'artists' => $artists
        ]);
    }

    public function show($slug)
    {
        $artist_info = DB::table('artists')->where('slug', $slug)->first();

        $artist_style = DB::table('styles')->select('slug')->where('id', $artist_info->style_id)->first();

        $albums = DB::table('albums')->where('artist_id', $artist_info->id)->orderByDesc('release')->get();

        $favorites = DB::table('artists_users')
        ->where('user_id', Auth::user()->id)
        ->select('artist_id')
        ->get();

        foreach ($favorites as $favorite) {
            if ($artist_info->id == $favorite->artist_id) {
                $artist_info->favorite = true;
            }
        }

        foreach($albums as $album){
            if($album->cover){
                if (file_exists(public_path('origin') . '/public/files/music/' . $artist_info->slug . '/' . $album->slug . '/' . $album->cover)) {
                    $album->cover = '/origin/public/files/music/' . $artist_info->slug . '/' . $album->slug . '/' . $album->cover;
                }else{
                    $album->cover = 'undefined.jpg';
                }
            }else{
                $album->cover = 'undefined.jpg';
            }
        }
        return view('artist.show')->with([
            'artist' => $artist_info,
            'style' => $artist_style,
            'albums' => $albums,
        ]);
    }
}
