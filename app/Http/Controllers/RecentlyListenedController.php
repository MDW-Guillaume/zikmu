<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecentlyListenedController extends Controller
{
    public function store(Request $request) {
        // dd($request['type']);

        $type = $request['type'];
        $element_id = $request['id'];

        $user_id = Auth::user()->id;
        // dd($user_id);
        // On récupère la liste des derniers écoutés

        $recent_list = DB::table('recently_listened')->where('user_id', $user_id)->get();
        $is_list_full = count($recent_list) == 10 ? true : false;

        if($is_list_full && $recent_list[9]){
            $tenthItem = $recent_list[9]->id;

            DB::table('recently_listened')->where('id', $tenthItem)->delete();
        }

        // On ajoute l'element a la liste en base

        DB::table('recently_listened')->insert([
            'user_id' => $user_id, // Assurez-vous d'avoir la valeur correcte pour user_id
            'element_type' => $type,
            'element_id' => $element_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true]);

        dd($recent_list, $is_list_full);
    }
}
