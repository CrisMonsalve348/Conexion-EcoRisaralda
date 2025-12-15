<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\reviews;


class ReviewsController extends Controller
{
    public function publicarreseña(Request $request, $id)
    {

        $request->validate([
            'review' => 'required|string|max:1000',
            
        ],[
            'review.required' => 'No puede enviar una reseña vacia.',

        ]);

        reviews::create([
            'comment' => $request->input('review'),
             'place_id' => $id,
            'user_id' => auth()->id(),
        ]);
        return redirect()->back()->with('success', 'Reseña publicada correctamente.');
      

        
    }
    public function eliminarreseña($id){
        $review = reviews::findOrFail($id);

        $review->delete();
        return redirect()->back()->with('success', 'Reseña eliminada correctamente.');
       

    }
    
}
