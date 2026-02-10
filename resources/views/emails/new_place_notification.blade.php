@php
$frontend = rtrim(config('app.frontend_url', config('app.url')), '/');
$placeUrl = $frontend . '/turista/sitio/' . $place->id;
$matched = is_array($matchedPreferences ?? null) ? $matchedPreferences : [];
@endphp

<x-mail::message>
# Nuevo sitio ecoturistico para ti

Hola,
encontramos un nuevo lugar que coincide con tus intereses.

@if($place->cover)
<img src="{{ asset('storage/' . $place->cover) }}" alt="{{ $place->name }}" style="width:100%;max-width:520px;border-radius:16px;margin:16px 0;" />
@endif

**{{ $place->name }}**

{{ $place->slogan }}

{{ \Illuminate\Support\Str::limit($place->description, 220) }}

@if(count($matched) > 0)
**Categorias relacionadas:** {{ implode(', ', $matched) }}
@endif

**Ubicacion:** {{ $place->localization }}

<x-mail::button :url="$placeUrl">
Ver sitio completo
</x-mail::button>

Recibiste este correo porque tienes activadas las notificaciones de Conexion EcoRisaralda.

Gracias,
Equipo Conexion EcoRisaralda
</x-mail::message>