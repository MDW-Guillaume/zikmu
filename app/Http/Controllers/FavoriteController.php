<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index(){
        $user = Auth::user();

        $my_user_favorite_songs = DB::table('songs_users')->where('user_id', $user->id)->select('id', 'song_id')->get();

        $user_favorite_array = array();



        /*
            Mes besoins 

            Nom du titre
            Nom de l'artiste
            Nom de l'album
            Image de l'album
        */

        // dd($my_user_favorite_songs);

        return view('favorite.index')->with([
            'user' => $user
        ]);
    }
}
