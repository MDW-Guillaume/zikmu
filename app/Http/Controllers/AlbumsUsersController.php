<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AlbumsUsersController extends Controller
{
    public function myalbums(){
        $user = Auth::user();

        $my_user_favorite_albums_db = DB::table('albums_users')->where('user_id', $user->id)->select('id', 'album_id')->get();

        $my_user_favorite_albums = [];

        $i = 0;
        foreach( $my_user_favorite_albums_db as $user_album){
            $album_db = DB::table('albums')->where('id', $user_album->album_id)->first();
            $artist = DB::table('artists')->select('name', 'slug')->where('id', $album_db->artist_id)->first();

            $album_db->artist_slug = $artist->slug;
            $album_db->artist_name = $artist->name;
            $album_db->cover = '/origin/public/files/music/' . $artist->slug . '/' . $album_db->slug . '/' . $album_db->cover;

            // if(!is_null($album_db->style_id)){
                //     $album_style = DB::table('styles')->where('id', $album_db->style_id)->first();
                //     $album_db->style = $album_style->slug;
                // }

                $my_user_favorite_albums[$i] = $album_db;
                $i++;
            }
            // dd($my_user_favorite_albums);

        return view('album.myalbums')->with([
            'albums' => $my_user_favorite_albums
        ]);
    }

    public function store(Request $request){
        $id_album = $request->input('album_id') ;

        $album_search = DB::table('albums_users')->where(['user_id' => Auth::User()->id, 'album_id' => $id_album])->get();

        if(count($album_search) >= 1){
            $album_insert = DB::table('albums_users')->where(['user_id' => Auth::User()->id, 'album_id' => $id_album])->delete();
            $action = 'delete';
        }else{
            $album_insert = DB::table('albums_users')->insert(['user_id' => Auth::User()->id, 'album_id' => $id_album]);
            $action = 'add';
        }

        return response()->json(['success' => true, 'action' => $action]);
    }
}
