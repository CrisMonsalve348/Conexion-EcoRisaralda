<x-mail::message>
# {{ $subjectLine }}

{{ $messageText }}

<x-mail::button :url="$actionUrl">
{{ $actionLabel }}
</x-mail::button>

Si no solicitaste estas notificaciones, puedes ignorar este correo.

Gracias,
Equipo Conexion EcoRisaralda
</x-mail::message>
