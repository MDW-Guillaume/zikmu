<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ArtistsUsersController extends Controller
{
    public function myartists(){
        $user = Auth::user();

        $my_user_favorite_artists = DB::table('artists_users')->where('user_id', $user->id)->select('id', 'artist_id')->get();

        return view('artist.myartists');
    }

    public function store(Request $request){
        $id_artist = $request->input('artist_id') ;

        $artist_search = DB::table('artists_users')->where(['user_id' => Auth::User()->id, 'artist_id' => $id_artist])->get();

        if(count($artist_search) >= 1){
            $artist_insert = DB::table('artists_users')->where(['user_id' => Auth::User()->id, 'artist_id' => $id_artist])->delete();
            $action = 'delete';
        }else{
            $artist_insert = DB::table('artists_users')->insert(['user_id' => Auth::User()->id, 'artist_id' => $id_artist]);
            $action = 'add';
        }

        return response()->json(['success' => true, 'action' => $action]);
    }
}
