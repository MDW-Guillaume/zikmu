<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;


class SongController extends Controller
{

    public function index()
    {
        return view('songqueue.index');
    }

    public function songQueue(Request $request)
    {

        if($request->position === null){
            return response()->json([
                'success' => true,
                'redirect' => 1,
                'url' => "/home"
                ]);
        }
        $songs_array = [];
        $i = 0;
        $user = Auth::user();

        if ($request->status == 'random') {
            // Récupération du son en fontion de la position de la file d'attente
            // $get_all_songs = DB::table('songs_queues')->where('user_id', $user->id)->where('random_position', '>=', $request->position)->orderBy('random_position')->get();
            $get_all_songs = DB::table('songs_queues')
            ->where('random_position', '>=', $request->position)
            ->where('user_id', $user->id)
            ->orderByRaw('random_position')
            ->get();

            $get_all_songs = $get_all_songs->sortBy('random_position')->values()->toArray();

            // $get_all_songs = $get_all_songs->sortBy('random_position');

        } else {
            // Récupération du son en fontion de la position de la file d'attente
            $get_all_songs = DB::table('songs_queues')->where('user_id', $user->id)->where('position', '>=', $request->position)->get();
        }


        foreach ($get_all_songs as $unique_song) {
            if ($i == 0) {
                // Récuération des informations relatives au son et création d'une URL à renvoyer en JSON
                $get_song_information = DB::table('songs')->where('id', $unique_song->song_id)->select('slug', 'name', 'album_id', 'length', 'position')->first();
                $get_album_information = DB::table('albums')->where('id', $get_song_information->album_id)->select('artist_id', 'slug', 'name', 'cover')->first();
                $get_artist_information = DB::table('artists')->where('id', $get_album_information->artist_id)->select('slug', 'name')->first();

                $songs_array[$i]['song_name'] = $get_song_information->name;
                $songs_array[$i]['song_length'] = $get_song_information->length;
                $songs_array[$i]['album_name'] = $get_album_information->name;
                $songs_array[$i]['artist_name'] = $get_artist_information->name;
                if ($request->status == 'random') {
                    $get_song_queue_position = DB::table('songs_queues')->where(['song_id' => $unique_song->song_id, 'user_id' => $user->id])->select('random_position')->first();
                    $songs_array[$i]['song_position'] = $get_song_queue_position->random_position;
                } else {
                    $get_song_queue_position = DB::table('songs_queues')->where(['song_id' => $unique_song->song_id, 'user_id' => $user->id])->select('position')->first();
                    $songs_array[$i]['song_position'] = $get_song_queue_position->position;
                }

                $song_slug = $get_song_information->slug;
                $album_slug = $get_album_information->slug;
                $album_cover = $get_album_information->cover;
                $artist_slug = $get_artist_information->slug;

                if ($album_cover) {
                    $songs_array[$i]['cover_url'] = '/storage/files/albums/' . $artist_slug . '/' . $album_cover;
                } else {
                    $songs_array[$i]['cover_url'] = '/img/unknown_cover.png';
                }
            } else {
                $get_song_information = DB::table('songs')->where('id', $unique_song->song_id)->select('name', 'length', 'album_id')->first();
                $get_favorite_status_song = DB::table('songs_users')->where(['user_id' => $user->id, 'song_id' => $unique_song->song_id])->first();

                if ($get_favorite_status_song) {
                    $songs_array[$i]['is_favorite'] = true;
                } else {
                    $songs_array[$i]['is_favorite'] = false;
                }
                $songs_array[$i]['song_id'] = $unique_song->song_id;
                $songs_array[$i]['song_name'] = $get_song_information->name;
                $songs_array[$i]['song_length'] = $get_song_information->length;
                if ($request->status == 'random') {
                    $get_song_queue_position = DB::table('songs_queues')->where(['song_id' => $unique_song->song_id, 'user_id' => $user->id])->select('random_position')->first();
                    $songs_array[$i]['song_position'] = $get_song_queue_position->random_position;
                } else {
                    $get_song_queue_position = DB::table('songs_queues')->where(['song_id' => $unique_song->song_id, 'user_id' => $user->id])->select('position')->first();
                    $songs_array[$i]['song_position'] = $get_song_queue_position->position;
                }
            }

            $i++;
        }
        return response()->json(['success' => true, 'request' => $songs_array]);
    }
    /*
        // public function listenPlaylist(Request $request)
        // {

        //     $favorite_titles = $request->input();
        //     foreach ($favorite_titles as $title) {
        //         if (preg_match('/^[0-9]+$/', $title)) {
        //             // Renvoie le slug du chemin pour les titres
        //             $song_info = DB::table('songs')->where('id', $title)->select('id', 'slug', 'album_id')->first();
        //             $album_info = DB::table('albums')->where('id', $song_info->album_id)->select('slug', 'release', 'length', 'artist_id')->first();
        //             $artist_info = DB::table('artists')->where('id', $album_info->artist_id)->select('slug')->first();

        //             $release = $album_info->release;
        //             $length = $album_info->length;
        //             $artist = $artist_info->slug;
        //             $album = $album_info->slug;
        //             $song_title = $song_info->slug;


        //             $song_array[] = $release . '-' . $length . '-' . $artist . '-' . $album . '/' . $song_title;

        //             // Renvoie le chemin avec les espaces mais a voir pourquoi je ne peux pas accéder a mon symbolic link

        //             // $song_info = DB::table('songs')->where('id', $title)->select('id', 'name', 'position', 'slug', 'album_id')->first();
        //             // $album_info = DB::table('albums')->where('id', $song_info->album_id)->select('name', 'slug', 'release', 'length', 'artist_id')->first();
        //             // $artist_info = DB::table('artists')->where('id', $album_info->artist_id)->select('name', 'slug')->first();

        //             // if($song_info->position < 10){
        //             //     $song_position = '0' . $song_info->position;
        //             // }else{
        //             //     $song_position = $song_info->position;
        //             // }
        //             // $release = $album_info->release;
        //             // $length = $album_info->length;
        //             // $artist = $artist_info->name;
        //             // $album = $album_info->name;
        //             // $song_title = $song_info->name;
        //             // $song_array[] = $release . ' - ' . $length . ' - ' . $artist . ' - ' . $album . '/' . $song_position . ' - ' . $song_title . '.mp3';
        //         }
        //     }

        //     return response()->json(['success' => true, 'request' => $song_array]);
        // }

        // public function listenAlbum(Request $request)
        // {
        //     $favorite_titles = $request->input();

        //     foreach ($favorite_titles as $title) {
        //         if (preg_match('/^[0-9]+$/', $title)) {
        //             $song_info = DB::table('songs')->where('id', $title)->select('id', 'slug', 'album_id')->first();
        //             $album_info = DB::table('albums')->where('id', $song_info->album_id)->select('slug', 'release', 'length', 'artist_id')->first();
        //             $artist_info = DB::table('artists')->where('id', $album_info->artist_id)->select('slug')->first();

        //             $release = $album_info->release;
        //             $length = $album_info->length;
        //             $artist = $artist_info->slug;
        //             $album = $album_info->slug;
        //             $song_title = $song_info->slug;


        //             $song_array[] = $release . '-' . $length . '-' . $artist . '-' . $album . '/' . $song_title;
        //         }
        //     }

        //     return response()->json(['success' => true, 'request' => $song_array]);
        // }

        // public function listenSong(Request $request)
        // {
        //     $song_info = DB::table('songs')->where('id', $request->title_id)->select('id', 'slug', 'album_id')->first();
        //     $album_info = DB::table('albums')->where('id', $song_info->album_id)->select('id', 'slug', 'release', 'length', 'artist_id')->first();
        //     $all_songs = DB::table('songs')->where('album_id', $album_info->id)->select('id', 'slug')->get();
        //     $artist_info = DB::table('artists')->where('id', $album_info->artist_id)->select('slug')->first();

        //     $release = $album_info->release;
        //     $length = $album_info->length;
        //     $artist = $artist_info->slug;
        //     $album = $album_info->slug;

        //     foreach ($all_songs as $song) {
        //         $song_array[] = $release . '-' . $length . '-' . $artist . '-' . $album . '/' . $song->slug;
        //     }

        //     return response()->json(['success' => true, 'songs' => $song_array, 'clickedSong' => $request->title_id]);
        // }

        // public function listenAlbumFormCover(Request $request)
        // {
        //     $album_input = $request->input('album_id');

        //     // dd($album_input);
        //     $all_songs = DB::table('songs')->where('album_id', $album_input)->select('id', 'slug')->get();
        //     $album_info = DB::table('albums')->where('id', $album_input)->select('id', 'slug', 'release', 'length', 'artist_id')->first();
        //     $artist_info = DB::table('artists')->where('id', $album_info->artist_id)->select('slug')->first();

        //     $release = $album_info->release;
        //     $length = $album_info->length;
        //     $artist = $artist_info->slug;
        //     $album = $album_info->slug;

        //     foreach ($all_songs as $song) {
        //         $song_title = $song->slug;
        //         $song_array[] = $release . '-' . $length . '-' . $artist . '-' . $album . '/' . $song_title;
        //     }

        //     return response()->json(['success' => true, 'request' => $song_array]);
        // }

        // public function listenUniqueFavorite(Request $request)
        // {

        //      ---------------------- CODE FONCTIONNEL ----------------------


        //     // $clicked_title = $request->input('title');


        //     // $clicked_info = DB::table('songs')->where('id', $clicked_title)->select('id', 'slug', 'album_id')->first();
        //     // $album_info = DB::table('albums')->where('id', $clicked_info->album_id)->select('slug', 'release', 'length', 'artist_id')->first();
        //     // $artist_info = DB::table('artists')->where('id', $album_info->artist_id)->select('slug')->first();

        //     // $release = $album_info->release;
        //     // $length = $album_info->length;
        //     // $artist = $artist_info->slug;
        //     // $album = $album_info->slug;
        //     // $song_title = $clicked_info->slug;

        //     // $song_array['clickedSong'] = $release . '-' . $length . '-' . $artist . '-' . $album . '/' . $song_title;

        //     // $user = Auth::user();

        //     // $my_user_favorite_songs = DB::table('songs_users')->where('user_id', $user->id)->select('song_id')->get();


        //     // foreach ($my_user_favorite_songs as $title) {
        //     //     $song_info = DB::table('songs')->where('id', $title->song_id)->select('id', 'slug', 'album_id')->first();
        //     //     $album_info = DB::table('albums')->where('id', $song_info->album_id)->select('slug', 'release', 'length', 'artist_id')->first();
        //     //     $artist_info = DB::table('artists')->where('id', $album_info->artist_id)->select('slug')->first();

        //     //     $release = $album_info->release;
        //     //     $length = $album_info->length;
        //     //     $artist = $artist_info->slug;
        //     //     $album = $album_info->slug;
        //     //     $song_title = $song_info->slug;


        //     //     $song_array[] = $release . '-' . $length . '-' . $artist . '-' . $album . '/' . $song_title;

        //     // }

        //     // return response()->json(['success' => true, 'songs' => $song_array]);




        //      ---------------------- AJOUT DE LA COVER ----------------------

        //     $clicked_title = $request->input('title');


        //     $clicked_info = DB::table('songs')->where('id', $clicked_title)->select('id', 'slug', 'album_id')->first();
        //     $album_info = DB::table('albums')->where('id', $clicked_info->album_id)->select('slug', 'release', 'length', 'cover', 'artist_id')->first();
        //     $artist_info = DB::table('artists')->where('id', $album_info->artist_id)->select('slug')->first();

        //     $release = $album_info->release;
        //     $length = $album_info->length;
        //     $artist = $artist_info->slug;
        //     $album = $album_info->slug;
        //     if (is_null($album_info->cover)) {
        //         $album_cover = "null";
        //     } else {
        //         $album_cover = $album_info->cover;
        //     }
        //     $song_title = $clicked_info->slug;
        //     // Si $album_cover est '' ca accepte la condition
        //     $song_array['clickedSong']['song'] = '/storage/files/music/' . $release . '-' . $length . '-' . $artist . '-' . $album . '/' . $song_title;
        //     if (file_exists(public_path('storage') . '/files/albums/' . $artist . '/' . $album_cover)) {
        //         $song_array['clickedSong']['cover'] = '/storage/files/albums/' . $artist . '/' . $album_cover;
        //     } else {
        //         $song_array['clickedSong']['cover'] = '/img/unknown_cover.png';
        //     }

        //     $user = Auth::user();

        //     $my_user_favorite_songs = DB::table('songs_users')->where('user_id', $user->id)->select('song_id')->get();

        //     $i = 0;
        //     foreach ($my_user_favorite_songs as $title) {
        //         $song_info = DB::table('songs')->where('id', $title->song_id)->select('id', 'name', 'slug', 'album_id')->first();
        //         $album_info = DB::table('albums')->where('id', $song_info->album_id)->select('slug', 'name', 'release', 'length', 'cover', 'artist_id')->first();
        //         $artist_info = DB::table('artists')->where('id', $album_info->artist_id)->select('slug', 'name')->first();

        //         $release = $album_info->release;
        //         $length = $album_info->length;
        //         $artist = $artist_info->slug;
        //         $artist_full_name = $artist_info->name;
        //         $album = $album_info->slug;
        //         $album_full_name = $album_info->name;
        //         $song_full_name = $song_info->name;
        //         if (is_null($album_info->cover)) {
        //             $album_cover = "null";
        //         } else {
        //             $album_cover = $album_info->cover;
        //         }
        //         $song_title = $song_info->slug;


        //         $song_array[$i]['song'] = '/storage/files/music/' . $release . '-' . $length . '-' . $artist . '-' . $album . '/' . $song_title;
        //         $song_array[$i]['artist'] = $artist_full_name;
        //         $song_array[$i]['album'] = $album_full_name;
        //         $song_array[$i]['songName'] = $song_full_name;
        //         if (file_exists(public_path('storage') . '/files/albums/' . $artist . '/' . $album_cover)) {
        //             $song_array[$i]['cover'] = '/storage/files/albums/' . $artist . '/' . $album_cover;
        //         } else {
        //             $song_array[$i]['cover'] = '/img/unknown_cover.png';
        //         }
        //         $i++;
        //     }

        //     // die;
        //     return response()->json(['success' => true, 'songs' => $song_array]);
        //     // return response()->json(['success' => true, 'songs' => $song_array]);
        // }
    */
}
