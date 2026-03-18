@php
$frontend = rtrim(config('app.frontend_url', config('app.url')), '/');
$placeUrl = $frontend . '/turista/sitio/' . $place->id;
$matched = is_array($matchedPreferences ?? null) ? $matchedPreferences : [];
@endphp

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
        .intro { color: #475569; font-size: 16px; line-height: 1.6; margin: 0 0 24px 0; }
        .image { margin: 24px 0; border-radius: 8px; overflow: hidden; }
        .image img { width: 100%; height: auto; display: block; max-width: 100%; margin: 0 auto; }
        .place-title { color: #1e293b; font-size: 22px; font-weight: 700; margin: 24px 0 8px 0; }
        .place-slogan { color: #10b981; font-size: 15px; font-weight: 600; font-style: italic; margin: 0 0 16px 0; }
        .place-description { color: #475569; font-size: 15px; line-height: 1.6; margin: 0 0 20px 0; }
        .categories { margin: 24px 0; padding-top: 24px; border-top: 1px solid #e2e8f0; }
        .categories-label { color: #64748b; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 12px 0; }
        .categories-list { display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; }
        .category-badge { display: inline-block; background-color: #dbeafe; color: #0369a1; padding: 6px 12px; border-radius: 999px; font-size: 12px; font-weight: 500; }
        .location { margin: 24px 0 0 0; padding-top: 24px; border-top: 1px solid #e2e8f0; color: #475569; font-size: 15px; }
        .location-label { color: #10b981; font-weight: 600; }
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
        <h2>Descubrimiento personalizado</h2>
    </div>

    <div class="body">
        <p class="intro">Encontramos un lugar que coincide perfectamente con tus intereses.</p>

        @if($place->cover)
        <div class="image">
            <img src="{{ asset('storage/' . $place->cover) }}" alt="{{ $place->name }}" />
        </div>
        @endif

        <h3 class="place-title">{{ $place->name }}</h3>

        @if($place->slogan)
        <p class="place-slogan">"{{ $place->slogan }}"</p>
        @endif

        <p class="place-description">{{ Illuminate\Support\Str::limit($place->description, 250) }}</p>

        @if(count($matched) > 0)
        <div class="categories">
            <p class="categories-label">Categorías relacionadas</p>
            <div class="categories-list">
                @foreach($matched as $category)
                <span class="category-badge">{{ $category }}</span>
                @endforeach
            </div>
        </div>
        @endif

        <div class="location">
            <p style="margin: 0;"><span class="location-label">Ubicación:</span><br/>{{ $place->localization }}</p>
        </div>

        <div class="button-wrapper">
            <a href="{{ $placeUrl }}" class="button">Explorar sitio completo</a>
        </div>

        <p class="footer-note">Recibiste este correo porque tienes activadas las notificaciones en Conexion EcoRisaralda.</p>
    </div>

    <div class="footer">
        <p>© 2026 Conexion EcoRisaralda. Todos los derechos reservados.</p>
    </div>
</div>
</body>
</html>