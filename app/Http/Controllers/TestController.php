<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index(){
        return view('test');
    }

    public function show(){
        $song_info = DB::table('songs')->where('id', 549)->select('slug', 'album_id')->first();
        $album_info = DB::table('albums')->where('id', $song_info->album_id)->select('slug', 'artist_id')->first();
        // dd($song_info->slug);
        // die;
        return view('test2')->with(['titre' => $album_info]);
    }
}
