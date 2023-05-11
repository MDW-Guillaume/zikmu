<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class SongController extends Controller
{

    public function index()
    {
        return view('waitinglist.index');
    }

    public function waitingList(Request $request)
    {

        $titles_url_array = $request->data;
        $song_name_array = [];

        foreach ($titles_url_array as $title_url) {
            $filename = basename($title_url); // récupère le nom du fichier avec l'extension : "recomposed-by-max-richter-vivaldi-the-four-seasons-spring-1.mp3"
            $name = pathinfo($filename, PATHINFO_FILENAME) . '.' . pathinfo($filename, PATHINFO_EXTENSION); // récupère le nom du fichier sans l'extension : "recomposed-by-max-richter-vivaldi-the-four-seasons-spring-1"
            $song_name_array[] = $name;
        }


        $i = 0;
        foreach ($song_name_array as $song_name) {
            $song_info = DB::table('songs')->where('slug', $song_name)->select('id', 'name', 'slug', 'album_id')->first();
            $album_info = DB::table('albums')->where('id', $song_info->album_id)->select('name', 'slug', 'release', 'length', 'artist_id')->first();
            $artist_info = DB::table('artists')->where('id', $album_info->artist_id)->select('slug', 'name')->first();

            $release = $album_info->release;
            $length = $album_info->length;
            $artist = $artist_info->name;
            $album = $album_info->name;
            $song_title = $song_info->name;
            $cover = 'albums/' . $artist_info->slug . '/' . $album_info->slug;

            $song_array[$i]['song'] = $song_title;
            $song_array[$i]['album'] = $album;
            $song_array[$i]['artist'] = $artist;
            $song_array[$i]['length'] = $length;
            $song_array[$i]['cover'] = $cover;
            $i++;
        }
        // dd($song_array);
        // die;

        return response()->json(['success' => true, 'request' => $song_array]);
    }

    public function listenPlaylist(Request $request)
    {

        $favorite_titles = $request->input();
        foreach ($favorite_titles as $title) {
            if (preg_match('/^[0-9]+$/', $title)) {
                // Renvoie le slug du chemin pour les titres
                $song_info = DB::table('songs')->where('id', $title)->select('id', 'slug', 'album_id')->first();
                $album_info = DB::table('albums')->where('id', $song_info->album_id)->select('slug', 'release', 'length', 'artist_id')->first();
                $artist_info = DB::table('artists')->where('id', $album_info->artist_id)->select('slug')->first();

                $release = $album_info->release;
                $length = $album_info->length;
                $artist = $artist_info->slug;
                $album = $album_info->slug;
                $song_title = $song_info->slug;


                $song_array[] = $release . '-' . $length . '-' . $artist . '-' . $album . '/' . $song_title;

                // Renvoie le chemin avec les espaces mais a voir pourquoi je ne peux pas accéder a mon symbolic link

                // $song_info = DB::table('songs')->where('id', $title)->select('id', 'name', 'position', 'slug', 'album_id')->first();
                // $album_info = DB::table('albums')->where('id', $song_info->album_id)->select('name', 'slug', 'release', 'length', 'artist_id')->first();
                // $artist_info = DB::table('artists')->where('id', $album_info->artist_id)->select('name', 'slug')->first();

                // if($song_info->position < 10){
                //     $song_position = '0' . $song_info->position;
                // }else{
                //     $song_position = $song_info->position;
                // }
                // $release = $album_info->release;
                // $length = $album_info->length;
                // $artist = $artist_info->name;
                // $album = $album_info->name;
                // $song_title = $song_info->name;
                // $song_array[] = $release . ' - ' . $length . ' - ' . $artist . ' - ' . $album . '/' . $song_position . ' - ' . $song_title . '.mp3';
            }
        }

        return response()->json(['success' => true, 'request' => $song_array]);
    }

    public function listenAlbum(Request $request)
    {

        // dd($request);
        $favorite_titles = $request->input();




        foreach ($favorite_titles as $title) {
            if (preg_match('/^[0-9]+$/', $title)) {
                $song_info = DB::table('songs')->where('id', $title)->select('id', 'slug', 'album_id')->first();
                $album_info = DB::table('albums')->where('id', $song_info->album_id)->select('slug', 'release', 'length', 'artist_id')->first();
                $artist_info = DB::table('artists')->where('id', $album_info->artist_id)->select('slug')->first();

                $release = $album_info->release;
                $length = $album_info->length;
                $artist = $artist_info->slug;
                $album = $album_info->slug;
                $song_title = $song_info->slug;


                $song_array[] = $release . '-' . $length . '-' . $artist . '-' . $album . '/' . $song_title;
            }
        }

        return response()->json(['success' => true, 'request' => $song_array]);
    }

    public function listenSong(Request $request)
    {
        $favorite_titles = $request->input();
        // dd($favorite_titles);
        foreach ($favorite_titles as $title) {
            if (preg_match('/^[0-9]+$/', $title)) {
                $song_info = DB::table('songs')->where('id', $title)->select('id', 'slug', 'album_id')->first();
                $album_info = DB::table('albums')->where('id', $song_info->album_id)->select('id', 'slug', 'release', 'length', 'artist_id')->first();
                $all_songs = DB::table('songs')->where('album_id', $album_info->id)->select('id', 'slug')->get();
                $artist_info = DB::table('artists')->where('id', $album_info->artist_id)->select('slug')->first();

                $release = $album_info->release;
                $length = $album_info->length;
                $artist = $artist_info->slug;
                $album = $album_info->slug;
            }
        }
        $is_selected_song = 0;
        foreach ($all_songs as $song) {
            if ($song_info->id == $song->id) {
                $is_selected_song = 1;
            }

            if ($is_selected_song == 1) {
                $song_title = $song->slug;
                $song_array[] = $release . '-' . $length . '-' . $artist . '-' . $album . '/' . $song_title;
            }
        }

        return response()->json(['success' => true, 'songs' => $song_array]);
    }

    public function listenAlbumFormCover(Request $request)
    {
        $album_input = $request->input('album_id');

        // dd($album_input);
        $all_songs = DB::table('songs')->where('album_id', $album_input)->select('id', 'slug')->get();
        $album_info = DB::table('albums')->where('id', $album_input)->select('id', 'slug', 'release', 'length', 'artist_id')->first();
        $artist_info = DB::table('artists')->where('id', $album_info->artist_id)->select('slug')->first();

        $release = $album_info->release;
        $length = $album_info->length;
        $artist = $artist_info->slug;
        $album = $album_info->slug;

        foreach ($all_songs as $song) {
            $song_title = $song->slug;
            $song_array[] = $release . '-' . $length . '-' . $artist . '-' . $album . '/' . $song_title;
        }

        return response()->json(['success' => true, 'request' => $song_array]);
    }

    public function listenUniqueFavorite(Request $request)
    {

        /* ---------------------- CODE FONCTIONNEL ---------------------- */


        // $clicked_title = $request->input('title');


        // $clicked_info = DB::table('songs')->where('id', $clicked_title)->select('id', 'slug', 'album_id')->first();
        // $album_info = DB::table('albums')->where('id', $clicked_info->album_id)->select('slug', 'release', 'length', 'artist_id')->first();
        // $artist_info = DB::table('artists')->where('id', $album_info->artist_id)->select('slug')->first();

        // $release = $album_info->release;
        // $length = $album_info->length;
        // $artist = $artist_info->slug;
        // $album = $album_info->slug;
        // $song_title = $clicked_info->slug;

        // $song_array['clickedSong'] = $release . '-' . $length . '-' . $artist . '-' . $album . '/' . $song_title;

        // $user = Auth::user();

        // $my_user_favorite_songs = DB::table('songs_users')->where('user_id', $user->id)->select('song_id')->get();


        // foreach ($my_user_favorite_songs as $title) {
        //     $song_info = DB::table('songs')->where('id', $title->song_id)->select('id', 'slug', 'album_id')->first();
        //     $album_info = DB::table('albums')->where('id', $song_info->album_id)->select('slug', 'release', 'length', 'artist_id')->first();
        //     $artist_info = DB::table('artists')->where('id', $album_info->artist_id)->select('slug')->first();

        //     $release = $album_info->release;
        //     $length = $album_info->length;
        //     $artist = $artist_info->slug;
        //     $album = $album_info->slug;
        //     $song_title = $song_info->slug;


        //     $song_array[] = $release . '-' . $length . '-' . $artist . '-' . $album . '/' . $song_title;

        // }

        // return response()->json(['success' => true, 'songs' => $song_array]);




        /* ---------------------- AJOUT DE LA COVER ---------------------- */

        $clicked_title = $request->input('title');


        $clicked_info = DB::table('songs')->where('id', $clicked_title)->select('id', 'slug', 'album_id')->first();
        $album_info = DB::table('albums')->where('id', $clicked_info->album_id)->select('slug', 'release', 'length', 'cover', 'artist_id')->first();
        $artist_info = DB::table('artists')->where('id', $album_info->artist_id)->select('slug')->first();

        $release = $album_info->release;
        $length = $album_info->length;
        $artist = $artist_info->slug;
        $album = $album_info->slug;
        if (is_null($album_info->cover)) {
            $album_cover = "null";
        } else {
            $album_cover = $album_info->cover;
        }
        $song_title = $clicked_info->slug;
        // Si $album_cover est '' ca accepte la condition
        $song_array['clickedSong']['song'] = '/storage/files/music/' . $release . '-' . $length . '-' . $artist . '-' . $album . '/' . $song_title;
        if (file_exists(public_path('storage') . '/files/albums/' . $artist . '/' . $album_cover)) {
            $song_array['clickedSong']['cover'] = '/storage/files/albums/' . $artist . '/' . $album_cover;
        } else {
            $song_array['clickedSong']['cover'] = '/img/unknown_cover.png';
        }

        $user = Auth::user();

        $my_user_favorite_songs = DB::table('songs_users')->where('user_id', $user->id)->select('song_id')->get();

        $i = 0;
        foreach ($my_user_favorite_songs as $title) {
            $song_info = DB::table('songs')->where('id', $title->song_id)->select('id', 'name', 'slug', 'album_id')->first();
            $album_info = DB::table('albums')->where('id', $song_info->album_id)->select('slug', 'name', 'release', 'length', 'cover', 'artist_id')->first();
            $artist_info = DB::table('artists')->where('id', $album_info->artist_id)->select('slug', 'name')->first();

            $release = $album_info->release;
            $length = $album_info->length;
            $artist = $artist_info->slug;
            $artist_full_name = $artist_info->name;
            $album = $album_info->slug;
            $album_full_name = $album_info->name;
            $song_full_name = $song_info->name;
            if (is_null($album_info->cover)) {
                $album_cover = "null";
            } else {
                $album_cover = $album_info->cover;
            }
            $song_title = $song_info->slug;


            $song_array[$i]['song'] = '/storage/files/music/' . $release . '-' . $length . '-' . $artist . '-' . $album . '/' . $song_title;
            $song_array[$i]['artist'] = $artist_full_name;
            $song_array[$i]['album'] = $album_full_name;
            $song_array[$i]['songName'] = $song_full_name;
            if (file_exists(public_path('storage') . '/files/albums/' . $artist . '/' . $album_cover)) {
                $song_array[$i]['cover'] = '/storage/files/albums/' . $artist . '/' . $album_cover;
            } else {
                $song_array[$i]['cover'] = '/img/unknown_cover.png';
            }
            $i++;
        }

        // die;
        return response()->json(['success' => true, 'songs' => $song_array]);
        // return response()->json(['success' => true, 'songs' => $song_array]);
    }
}
