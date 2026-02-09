<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="img/svg" href="./img/sitios_ecoturisticos/nature-svgrepo-com.svg">
    @vite(['resources/css/app.css', 'resources/css/style_Coleccion.css', 'resources/js/app.js'])
    <title>Conexión EcoRisaralda</title>
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
 <div class="container">
        <div class="header">
            <h1>🌿 ¡Nuevo sitio ecoturístico!</h1>
            <p>Hemos agregado un nuevo lugar que coincide con tus intereses</p>
        </div>

        @if($place->cover)
            <img src="{{ asset('storage/' . $place->cover) }}" alt="{{ $place->name }}" class="place-image">
        @endif

        <h2>{{ $place->name }}</h2>
        <p><strong>{{ $place->slogan }}</strong></p>
        <p>{{ Str::limit($place->description, 200) }}</p>

        <div class="tags">
            <p><strong>Categorías que te interesan:</strong></p>
        
        </div>

        <p><strong>📍 Ubicación:</strong> {{ $place->localization }}</p>

        <a href="{{ url('/Sitio/' . $place->id) }}" class="btn">Ver sitio completo</a>

        <p style="margin-top: 30px; color: #666; font-size: 12px;">
         Recibiste este correo porque tienes activadas las notificaciones de Conexión EcoRisaralda.
        </p>
    </div>


</body>
</html>