<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecentlyListenedController extends Controller
{
    public function store(Request $request) {
        $album_id = $request['album_id'];

        $user_id = Auth::user()->id;
        // On récupère la liste des derniers écoutés

        $recent_list = DB::table('recently_listeneds')
                        ->where('user_id', $user_id)
                        ->orderBy('updated_at', 'asc')
                        ->get();
        $is_list_full = count($recent_list) == 10 ? true : false;

        $foundItem = $recent_list->firstWhere('album_id', $album_id);

        if($foundItem){
            DB::table('recently_listeneds')
            ->where(['user_id' => $user_id, 'album_id' => $album_id])
            ->update(['updated_at' => now()]);
        }else{
            if($is_list_full){
                $oldest_data = $recent_list[0];
                DB::table('recently_listeneds')->where('id', $oldest_data->id)->delete();
            }

            DB::table('recently_listeneds')->insert([
                'user_id'       => $user_id,
                'album_id'      => $album_id,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
        return response()->json(['success' => true]);
    }
}
