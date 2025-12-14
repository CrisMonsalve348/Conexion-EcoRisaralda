<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TuristicPlace;
use Illuminate\Support\Facades\Storage;


class TuristicPlaceController extends Controller
{
    public function crear()
    {
        return view('sitios_ecoturisticos.Crear_sitio');
    }

    public function validarsitio(Request $request)
    {
        $request->validate([
            'nombre'               => 'required|string|max:255',
            'slogan'               => 'required|string|max:255',
            'descripcion'          => 'required|string|min:10',
            'localizacion'         => 'required|string|min:10',
            'lat'                  =>'required',
            'lng'                  => 'required',
            'clima'                => 'required|string|min:10',
            'caracteristicas'      => 'required|string|min:10',
            'flora'                => 'required|string|min:10',
            'infraestructura'      => 'required|string|min:10',
            'recomendacion'        => 'required|string|min:10',

            // imágenes
            'portada'              => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'clima_img'            => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'caracteristicas_img'  => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'flora_img'            => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'infraestructura_img'  => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',

            // términos y políticas
            'terminos'             => 'accepted',
            'politicas'            => 'accepted',

        ], [
            'nombre.required'   => 'Debe ingresar el nombre del sitio.',
            'slogan.required'   => 'Debe ingresar el slogan.',
            'descripcion.required' => 'Debe ingresar la descripción.',
            'localizacion.required' => 'Debe ingresar la localización.',
            'lat.required'          => 'debe ubicar la latitud',
            'lng.required'          =>'debe ubicar la longitud',
            'clima.required' => 'Debe ingresar el clima.',
            'caracteristicas.required' => 'Debe ingresar las características.',
            'flora.required' => 'Debe ingresar la flora y fauna.',
            'infraestructura.required' => 'Debe ingresar la infraestructura.',
            'recomendacion.required' => 'Debe ingresar recomendaciones.',

            'terminos.accepted' => 'Debe aceptar los términos.',
            'politicas.accepted' => 'Debe aceptar las políticas.',
        ]);

        // Guardar imágenes
        $portada_path = $request->file('portada')->store('portadas', 'public');
        $clima_path = $request->file('clima_img')->store('clima', 'public');
        $caracteristicas_path = $request->file('caracteristicas_img')->store('caracteristicas', 'public');
        $flora_path = $request->file('flora_img')->store('flora', 'public');
        $infraestructura_path = $request->file('infraestructura_img')->store('infraestructura', 'public');

        // Guardado en DB
        TuristicPlace::create([
            'user_id'             => auth()->id(),

            'name'              => $request->nombre,
            'slogan'              => $request->slogan,
            'description'         => $request->descripcion,
            'localization'        => $request->localizacion,
            'lat'                 =>$request->lat,
            'lng'                  =>$request->lng,
            'Weather'               => $request->clima,
            'features'     => $request->caracteristicas,
            'flora'               => $request->flora,
            'estructure'     => $request->infraestructura,
            'tips'       => $request->recomendacion,

            'cover'             => $portada_path,
            'Weather_img'           => $clima_path,
            'features_img' => $caracteristicas_path,
            'flora_img'           => $flora_path,
            'estructure_img' => $infraestructura_path,

            'terminos'            => true,
            'politicas'           => true,
        ]);

        return redirect()->route('gestionar_sitios')->with('success', 'Sitio creado correctamente.');
    }
  public function gestionsitios()
{
    $user = auth()->user();
    
    if ($user->role == 'operator') {
        $places = TuristicPlace::where('user_id', $user->id)->get();
    } elseif ($user->role == 'admin') {
        $places = TuristicPlace::all();
    } else {
      
        abort(403, 'No tienes permisos para acceder a esta página');
    }
    
    return view('sitios_ecoturisticos.Gestion_sitio', compact('user', 'places'));
}

    public function destroy($id)
{
    $place = TuristicPlace::findOrFail($id);
    
    // Eliminar la imagen del storage
    if ($place->cover) {
        Storage::disk('public')->delete($place->cover);
    }
    
    $place->delete();
    
    return redirect()->route('gestionar_sitios')->with('success', 'Sitio eliminado correctamente');
}

    public function editar($id)
    {
        $place = TuristicPlace::findOrFail($id);
        return view('sitios_ecoturisticos.Editar_sitio', compact('place'));
    }

}
