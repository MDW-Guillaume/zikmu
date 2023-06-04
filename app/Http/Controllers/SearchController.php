<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Album;
use App\Models\Artist;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class SearchController extends Controller
{
    public function index()
    {
        return view('search.index');
    }

    public function show(Request $request)
    {
        $search_array = [];
        $songs_similar = Song::where('name', 'LIKE', $request->search . '%')
            ->orWhere('name', 'LIKE', '%' . $request->search . '%')
            ->get();

        $albums_similar = Album::where('name', 'LIKE', $request->search . '%')
            ->orWhere('name', 'LIKE', '%' . $request->search . '%')
            ->get();
        $artists_similar = Artist::where('name', 'LIKE', $request->search . '%')
            ->orWhere('name', 'LIKE', '%' . $request->search . '%')
            ->get();

        foreach ($songs_similar as $song_similar) {
            $get_album_information = DB::table('albums')->where('id', $song_similar->album_id)->select('artist_id', 'slug', 'length', 'release', 'name', 'cover')->first();
            $get_artist_information = DB::table('artists')->where('id', $get_album_information->artist_id)->select('slug', 'name')->first();

            $album_cover = $get_album_information->cover;
            $album_slug = $get_album_information->slug;
            $artist_slug = $get_artist_information->slug;


            if ($album_cover) {
                $cover_url = '/origin/public/files/music/' . $artist_slug . '/' . $album_slug . '/' . $album_cover;
            } else {
                $cover_url = '/img/unknown_cover.png';
            }

            $search_array['songs'][$song_similar->id]['id'] = $song_similar->id;
            $search_array['songs'][$song_similar->id]['name'] = $song_similar->name;
            $search_array['songs'][$song_similar->id]['cover'] = $cover_url;
        }

        foreach ($albums_similar as $album_similar) {
            $get_album_information = DB::table('albums')->where('id', $album_similar->id)->select('artist_id', 'slug', 'length', 'release', 'name', 'cover')->first();
            $get_artist_information = DB::table('artists')->where('id', $get_album_information->artist_id)->select('slug', 'name')->first();

            $album_cover = $get_album_information->cover;
            $album_slug = $get_album_information->slug;
            $album_release = $get_album_information->release;
            $artist_slug = $get_artist_information->slug;
            $artist_name = $get_artist_information->name;


            if ($album_cover) {
                $cover_url = '/origin/public/files/music/' . $artist_slug . '/' . $album_slug . '/' . $album_cover;
            } else {
                $cover_url = '/img/unknown_cover.png';
            }

            $search_array['albums'][$album_similar->id]['id'] = $album_similar->id;
            $search_array['albums'][$album_similar->id]['name'] = $album_similar->name;
            $search_array['albums'][$album_similar->id]['slug'] = $album_slug;
            $search_array['albums'][$album_similar->id]['cover'] = $cover_url;
            $search_array['albums'][$album_similar->id]['release'] = $album_release;
            $search_array['albums'][$album_similar->id]['artist_name'] = $artist_name;
        }

        foreach ($artists_similar as $artist_similar) {
            $artist_info = DB::table('artists')->where('slug', $artist_similar->slug)->first();
            $artist_style = DB::table('styles')->select('slug')->where('id', $artist_info->style_id)->first();

            $artist_followers = $artist_info->follow;
            $artist_cover = $artist_info->cover;


            if ($artist_cover) {
                $cover_url = $artist_style->slug . '/' . $artist_cover;
            } else {
                $cover_url = '/img/unknown.png';
            }


            $search_array['artists'][$artist_similar->id]['id'] = $artist_similar->id;
            $search_array['artists'][$artist_similar->id]['name'] = $artist_similar->name;
            $search_array['artists'][$artist_similar->id]['slug'] = $artist_similar->slug;
            $search_array['artists'][$artist_similar->id]['cover'] = $cover_url;
            $search_array['artists'][$artist_similar->id]['follow'] = $artist_followers;
            $search_array['artists'][$artist_similar->id]['style'] = $artist_followers;
        }

        $view = view('search.index', compact('search_array'))->render();

        return response()->json(['success' => true, 'data' => $view]);
        // return response()->json(['data' => view('search.index', compact('search_array'))]);
        // return response()->json(['data' => view('search.index'), 'search_array' => $search_array]);
        // dd($search_array);
    }
}
