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

        /*
        // $music_path = File::allFiles(public_path('music'));

        // $musical_path = scandir(public_path('music') . '/music');
        // $musical_title = array();

        $musical_path = scandir(public_path('music') . '/music');

        $zikmu = array();
        for($i = 2; $i < count($musical_path) - 1; $i++){
            $musical_explode = explode(' - ', $musical_path[$i]);
            $zikmu[$musical_explode[2]][$musical_explode[3]]["release"] = $musical_explode[0];
            $zikmu[$musical_explode[2]][$musical_explode[3]]["length"] = $musical_explode[1];
            $zikmu[$musical_explode[2]][$musical_explode[3]]["titles"] = array();

            //Récupération du titre de la musique, rangé dans la colonne correspondante

            $album_content = scandir(public_path('music') . '/music/' . $musical_path[$i]);

            for($j = 2; $j < count($album_content) -2; $j++){
                $title_explode = explode(' - ', $album_content[$j]);
                $zikmu[$musical_explode[2]][$musical_explode[3]]["titles"][] = array("position" => $title_explode[0], "name" => $title_explode[1], "slug" => $title_explode[1]);

            }
        }
        */

        $zikmu = array();

        // On récupère la liste de tous les genres enregistrés sur le site
        $styles = DB::table('styles')->select('name', 'id', 'slug')->get();

        // On récupère une liste d'artistes les plus aimés
        $db_artists = DB::table('artists')->orderByDesc('follow')->get();

        for ($i = 0; $i < count($db_artists); $i++) {
            $artists[$i]['id'] = $db_artists[$i]->id;
            $artists[$i]['name'] = $db_artists[$i]->name;
            $artists[$i]['slug'] = $db_artists[$i]->slug;
            $style_name = DB::table('styles')->select('slug')->where('id', $db_artists[$i]->style_id)->first();



            if (!is_null($style_name)) {
                if (!is_null($db_artists[$i]->cover)) {
                    if (file_exists(storage_path() . '/app/files/artistes/' . $style_name->slug . '/' . $db_artists[$i]->cover)) {
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
