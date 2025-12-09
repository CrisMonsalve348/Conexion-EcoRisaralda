<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TuristicPlaceController extends Controller
{
    //mostrar la vista
       public function crear()
    {
        return view('sitios_ecoturisticos.Crear_sitio');
    }
    //validar los datos mandados
    public function validarsitio(Request $request)
    {
        $request->validate(
            [
                // Campos básicos
                'name'          => 'required|min:1|max:255',
                'slogan'        => 'required|min:1|max:255',

                // Descripciones largas
                'description'   => 'required|min:10|max:5000',
                'localization'  => 'required|min:10|max:3000',
                'Weather'       => 'required|min:10|max:2000',
                'flora'         => 'required|min:10|max:2000',
                'estructure'    => 'required|min:10|max:3000',
                'tips'          => 'required|min:10|max:2000',

                // Imágenes
                'cover'         => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
                'Weather_img'   => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
                'flora_img'     => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
                'estructure_img'=> 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            ],

            [
                // NAME
                'name.required' => 'Debe poner el nombre del sitio.',
                'name.max'      => 'El nombre no puede superar 255 caracteres.',

                // SLOGAN
                'slogan.required' => 'Debe poner el slogan del sitio.',
                'slogan.max'      => 'El slogan no puede superar 255 caracteres.',

                // DESCRIPCIONES
                'description.required' => 'Debe ingresar una descripción del sitio.',
                'localization.required' => 'Debe ingresar la localización del sitio.',
                'Weather.required' => 'Debe describir el clima del sitio.',
                'flora.required' => 'Debe describir la flora del sitio.',
                'estructure.required' => 'Debe describir la estructura del sitio.',
                'tips.required' => 'Debe ingresar recomendaciones del sitio.',

                // IMÁGENES
                'cover.required' => 'Debe subir una imagen de portada.',
                'cover.image'    => 'La portada debe ser una imagen.',
                'cover.mimes'    => 'La portada solo acepta formatos: jpg, jpeg, png, webp.',
                'cover.max'      => 'La imagen de portada no puede superar 4 MB.',

                'Weather_img.required' => 'Debe subir una imagen relacionada con el clima.',
                'Weather_img.image'    => 'La imagen de clima debe ser un archivo válido.',
                'Weather_img.mimes'    => 'Formatos permitidos: jpg, jpeg, png, webp.',
                'Weather_img.max'      => 'Esta imagen no puede superar 4 MB.',

                'flora_img.required' => 'Debe subir una imagen relacionada con la flora.',
                'estructure_img.required' => 'Debe subir una imagen de la infraestructura.',
            ]
        );
    }
}
