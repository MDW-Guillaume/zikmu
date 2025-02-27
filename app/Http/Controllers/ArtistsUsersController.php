<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ArtistsUsersController extends Controller
{
    public function myartists(){
        $user = Auth::user();

        $my_user_favorite_artists_db = DB::table('artists_users')->where('user_id', $user->id)->select('id', 'artist_id')->get();

        $my_user_favorite_artists = [];

        $i = 0;
        foreach( $my_user_favorite_artists_db as $user_artist){
            $artist_db = DB::table('artists')->where('id', $user_artist->artist_id)->first();

            if(!is_null($artist_db->style_id)){
                $artist_style = DB::table('styles')->where('id', $artist_db->style_id)->first();
                $artist_db->style = $artist_style->slug;
            }

            $my_user_favorite_artists[$i] = $artist_db;
            $i++;
        }

        return view('artist.myartists')->with([
            'artists' => $my_user_favorite_artists
        ]);
    }

    public function store(Request $request){
        $id_artist = $request->input('artist_id') ;

        // Recherche de la présence de l'artiste dans la table `artists_users`
        $artist_search = DB::table('artists_users')->where(['user_id' => Auth::User()->id, 'artist_id' => $id_artist])->get();

        // Ajout ou suppression de l'artiste en fonction du la valeur de $artist_search
        // +
        // Ajout ou suppression d'un follow sur l'artiste
        if(count($artist_search) >= 1){
            $artist_insert = DB::table('artists_users')->where(['user_id' => Auth::User()->id, 'artist_id' => $id_artist])->delete();
            DB::table('artists')->where('id', $id_artist)->decrement('follow');
            $action = 'delete';
        }else{
            $artist_insert = DB::table('artists_users')->insert(['user_id' => Auth::User()->id, 'artist_id' => $id_artist]);
            DB::table('artists')->where('id', $id_artist)->increment('follow');
            $action = 'add';
        }



        return response()->json(['success' => true, 'action' => $action]);
    }
}
