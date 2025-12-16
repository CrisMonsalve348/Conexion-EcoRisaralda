<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="icon" type="image/svg+xml" href="{{ asset('img/inicio_sesion/nature-svgrepo-com.svg') }}">
  
  @vite(['resources/css/app.css', 'resources/css/style_Sitio.css', 'resources/js/app.js'])
  <link rel="stylesheet" href="{{ asset('css/style_Sitio.css') }}">
  
  <title>Sitios</title>
</head>
<body>
   
    @foreach($favoritePlaces as $place)
    <a href="/Sitio/{{ $place->id }}">
        <div class="sitio-ecoturistico">
            <img src="{{ asset('storage/' . $place->cover) }}" alt="{{ $place->name }}" class="imagen-sitio">
            <h2>{{ $place->name }}</h2>
            <p>{{ $place->user->name }}</p>

    @endforeach

    </a>



<body>
<html>