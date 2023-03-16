<?php

namespace App\Http\Controllers;

use App\Models\Style;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function show()
    {
        return view('landing');
    }

    public function index()
    {

        $zikmu = array();

        // On récupère la liste de tous les genres enregistrés sur le site
        $styles = DB::table('styles')->select('name', 'id', 'slug')->get();

        // On récupère une liste d'artistes les plus aimés
        $db_artists = DB::table('artists')->orderByDesc('follow')->take(10)->get();

        for ($i = 0; $i < count($db_artists); $i++) {
            $artists[$i]['id'] = $db_artists[$i]->id;
            $artists[$i]['name'] = $db_artists[$i]->name;
            $artists[$i]['slug'] = $db_artists[$i]->slug;
            $style_name = DB::table('styles')->select('slug')->where('id', $db_artists[$i]->style_id)->first();



            if (!is_null($style_name)) {
                if (!is_null($db_artists[$i]->cover)) {
                    if (file_exists(storage_path() . '/app/public/files/artistes/' . $style_name->slug . '/' . $db_artists[$i]->cover)) {
                        $artists[$i]['cover'] = $db_artists[$i]->cover;
                        $artists[$i]['style_slug'] = $style_name->slug;
                    } else {
                        $artists[$i]['cover'] = 'unfinded.jpg';
                        $artists[$i]['style_slug'] = 'unfinded';
                    }
                } else {
                    $artists[$i]['cover'] = 'unfinded.jpg';
                    $artists[$i]['style_slug'] = 'unfinded';
                }
            } else {
                $artists[$i]['cover'] = 'unfinded.jpg';
                $artists[$i]['style_slug'] = 'unfinded';
            }
            $artists[$i]['follow'] = $db_artists[$i]->follow;

        }
        // dd($artists);

        return view('test')->with([
            'music' => $zikmu,
            'styles' => $styles,
            'artists' => $artists
        ]);
    }
}
