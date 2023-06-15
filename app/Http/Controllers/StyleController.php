<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StyleController extends Controller
{
    public function index()
    {
        $styles = DB::table('styles')->get();

        return view('style.index')->with([
            'styles' => $styles
        ]);
    }

    public function show($slug)
    {
        $style = DB::table('styles')->where('slug', $slug)->first();

        $artists = DB::table('artists')->where('style_id', $style->id)->orderByDesc('follow')->get();

        $albums = array();

        foreach ($artists as $artist) {
            $albums_of_artist = DB::table('albums')->where('artist_id', $artist->id)->inRandomOrder()->get();
            foreach ($albums_of_artist as $unique_album) {
                $albums[$unique_album->slug] = $unique_album;
                $albums[$unique_album->slug]->artist = $artist->name;
                $albums[$unique_album->slug]->artist_slug = $artist->slug;
                if ($unique_album->cover) {
                    if (file_exists(public_path('origin') . '/public/files/music/' . $artist->slug . '/' . $unique_album->slug . '/' . $unique_album->cover)) {
                        $albums[$unique_album->slug]->cover = '/origin/public/files/music/' . $artist->slug . '/' . $unique_album->slug . '/' . $unique_album->cover;
                    } else {
                        $albums[$unique_album->slug]->cover = 'undefined.jpg';
                    }
                } else {
                    $albums[$unique_album->slug]->cover = 'undefined.jpg';
                }
            }
            if ($artist->cover) {
                if (file_exists(public_path('origin') . '/public/files/music/' . $artist->slug . '/' . $artist->cover)) {
                    $artist->cover = '/origin/public/files/music/' . $artist->slug . '/' . $artist->cover;
                } else {
                    $artist->cover = 'undefined.jpg';
                }
            } else {
                $artist->cover = 'undefined.jpg';
            }
        }

        shuffle($albums);

        return view('style.show')->with([
            'style' => $style,
            'artists' => $artists,
            'albums' => $albums
        ]);
    }
}
