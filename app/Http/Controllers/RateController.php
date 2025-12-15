<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rate;
use App\Models\reviews;


class RateController extends Controller
{
    public function promedio($id){

        $placeRates = Rate::where('place_id', $id)->get();
        if ($placeRates->isEmpty()) {
            return 0;
        }
        $average = $placeRates->avg('rating');
        return round($average, 2);

    }
}
