<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DanceGenreController extends Controller
{
    public function show(Request $request){
        $dance_genres = \DB::table('dance_genre')->get();
        $returnArray=[];
        foreach ($dance_genres as $dance_genre) {
            array_push($returnArray,$dance_genre->dance_genre_name);
        }
        dd($returnArray);
        return response()->json($returnArray,200);
    }
}
