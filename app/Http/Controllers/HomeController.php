<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function show(){
        return view('landing');
    }

    public function index(){
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
        // dd($zikmu);

        return view('test')->with('music', $zikmu);
    }
}
