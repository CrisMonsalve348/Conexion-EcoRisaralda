<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class preferenceController extends Controller
{
    public function mostrardatosdepreferencias(){
        $preferences = \App\Models\preferences::all();
        return view('preferencias', compact('preferences'));
    }
}
 