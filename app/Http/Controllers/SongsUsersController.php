<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SongsUsersController extends Controller
{
    public function store(Request $request){
        $id_song = $request->input('title') ;
        $id_user = $request->input('user') ;
        // dd(Auth::User()->id);

        $song_search = DB::table('songs_users')->where(['user_id' => Auth::User()->id, 'song_id' => $id_song])->get();

        if(count($song_search) >= 1){
            $song_insert = DB::table('songs_users')->where(['user_id' => Auth::User()->id, 'song_id' => $id_song])->delete();
        }else{
        $song_insert = DB::table('songs_users')->insert(['user_id' => Auth::User()->id, 'song_id' => $id_song]);
        }

        // dd($song_search);
        
    return response()->json(['success' => true]);

    }
}
