<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function show(Request $request){
        $view = view('player.show')->render();
        return response()->json(['success' => true, 'data' => $view]);
    }
}
