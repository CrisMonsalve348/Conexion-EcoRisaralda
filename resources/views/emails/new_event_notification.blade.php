@component('mail::message')
# ¡Nuevo evento en uno de tus sitios favoritos!

Hola {{ $user->name }},

Se ha publicado un nuevo evento en el sitio **{{ $place->name }}** que tienes en tus favoritos.

**Evento:** {{ $event->title }}

@if($event->description)
{{ $event->description }}
@endif

**Fecha de inicio:** {{ $event->starts_at->format('d/m/Y H:i') }}
@if($event->ends_at)

**Fecha de fin:** {{ $event->ends_at->format('d/m/Y H:i') }}
@endif

@component('mail::button', ['url' => config('app.frontend_url', config('app.url')) . '/turista/sitio/' . $place->id . '#evento-' . $event->id])
Ver evento
@endcomponent

¡No te lo pierdas!

Gracias por usar nuestra plataforma.
@endcomponent
