<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rate;
use App\Models\reviews;



class RateController extends Controller
{
    public function promedio($id){

         $average = reviews::where('place_id', $id)->avg('rating');

         Rate::updateOrCreate(
            ['place_id' => $id],
            ['rating' => round($average, 2)]
         );
    }
}
