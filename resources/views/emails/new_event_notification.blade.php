<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Albert Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background-color: #f8fafc; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); }
        .header { background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 48px 32px; text-align: center; }
        .header h2 { margin: 0; color: #ffffff; font-size: 28px; font-weight: 700; letter-spacing: -0.5px; }
        .body { padding: 40px 32px; text-align: center; }
        .greeting { color: #475569; font-size: 16px; line-height: 1.6; margin: 0 0 32px 0; }
        .card { background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border-radius: 12px; padding: 28px; margin: 32px 0; text-align: left; border-left: 5px solid #10b981; }
        .card .site-label { margin: 0 0 12px 0; color: #64748b; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .card h3 { margin: 0 0 16px 0; color: #1e293b; font-size: 22px; font-weight: 700; }
        .card p { margin: 0 0 16px 0; color: #475569; font-size: 15px; line-height: 1.6; }
        .card p:last-child { margin: 0; }
        .card .info { border-top: 1px solid rgba(16, 185, 129, 0.3); padding-top: 16px; margin-top: 16px; }
        .card .info p { text-align: left; color: #475569; font-size: 14px; margin: 0 0 8px 0; }
        .card .info p:last-child { margin: 0; }
        strong { color: #10b981; }
        .button-wrapper { text-align: center; margin: 36px 0; }
        .button { display: inline-block; background-color: #10b981; color: #ffffff; text-decoration: none; border-radius: 999px; padding: 14px 40px; font-weight: 600; font-size: 16px; }
        .footer-note { color: #64748b; font-size: 14px; line-height: 1.5; margin: 0; }
        .footer { background-color: #f8fafc; padding: 24px 32px; text-align: center; border-top: 1px solid #e2e8f0; }
        .footer p { margin: 0; color: #94a3b8; font-size: 12px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>Nuevo evento disponible</h2>
    </div>

    <div class="body">
        <p class="greeting">Hola {{ $user->name }}, hemos encontrado un evento que te puede interesar en uno de tus sitios favoritos.</p>

        <div class="card">
            <p class="site-label">Sitio: {{ $place->name }}</p>
            <h3>{{ $event->title }}</h3>
            
            @if($event->description)
            <p>{{ $event->description }}</p>
            @endif
            
            <div class="info">
                <p><strong>Inicio:</strong> {{ $event->starts_at->format('d \\d\\e M \\d\\e Y \\a \\l\\a\\s H:i') }}</p>
                @if($event->ends_at)
                <p><strong>Fin:</strong> {{ $event->ends_at->format('d \\d\\e M \\d\\e Y \\a \\l\\a\\s H:i') }}</p>
                @endif
            </div>
        </div>

        <div class="button-wrapper">
            <a href="{{ config('app.frontend_url', config('app.url')) }}/turista/sitio/{{ $place->id }}#evento-{{ $event->id }}" class="button">
                Ver evento completo
            </a>
        </div>

        <p class="footer-note">Recibiste este correo porque tienes activadas las notificaciones en Conexion EcoRisaralda.</p>
    </div>

    <div class="footer">
        <p>© 2026 Conexion EcoRisaralda. Todos los derechos reservados.</p>
    </div>
</div>
</body>
</html>

        <div class="card">
            <p class="label">Sitio: {{ $place->name }}</p>
            <h3>{{ $event->title }}</h3>
            
            @if($event->description)
            <p>{{ $event->description }}</p>
            @endif
            
            <div class="info">
                <p><strong>Inicio:</strong> {{ $event->starts_at->format('d \\d\\e M \\d\\e Y \\a \\l\\a\\s H:i') }}</p>
                @if($event->ends_at)
                <p><strong>Fin:</strong> {{ $event->ends_at->format('d \\d\\e M \\d\\e Y \\a \\l\\a\\s H:i') }}</p>
                @endif
            </div>
        </div>

        <div class="button-wrapper">
            <a href="{{ config('app.frontend_url', config('app.url')) }}/turista/sitio/{{ $place->id }}#evento-{{ $event->id }}" class="button">
                Ver evento completo
            </a>
        </div>

        <p class="footer-note">Recibiste este correo porque tienes activadas las notificaciones en Conexion EcoRisaralda.</p>
    </div>

    <div class="footer">
        <p>© 2026 Conexion EcoRisaralda. Todos los derechos reservados.</p>
    </div>
</div>
</body>
</html>
