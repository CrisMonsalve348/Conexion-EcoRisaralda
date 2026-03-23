@php
$frontendUrl = rtrim(config('app.frontend_url', config('app.url')), '/');
$logoUrl = $frontendUrl . '/images/Pagina_inicio/nature-svgrepo-com.svg';
$placeUrl = $frontendUrl . '/turista/sitio/' . $place->id;
$matched = is_array($matchedPreferences ?? null) ? $matchedPreferences : [];
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin: 0; padding: 40px 20px; background-color: #ffffff; }
        .container { max-width: 500px; margin: 0 auto; background-color: #ffffff; }
        .header { text-align: center; margin-bottom: 32px; }
        .logo { display: inline-flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo-icon { width: 32px; height: 32px; }
        .logo-text { font-size: 18px; font-weight: 700; color: #1e293b; letter-spacing: -0.3px; text-align: left; line-height: 1.2; }
        .logo-sub { font-size: 13px; color: #16a34a; font-weight: 600; display: block; }
        .divider { width: 40px; height: 2px; background-color: #e2e8f0; margin: 24px auto 0; }
        
        .body h2 { margin: 0 0 16px; color: #1e293b; font-size: 20px; font-weight: 700; text-align: center; }
        .body > p:first-of-type { color: #475569; font-size: 15px; line-height: 1.6; margin: 0 0 32px; text-align: center; }
        
        .cover-image { width: 100%; height: auto; display: block; border-radius: 8px; margin-bottom: 24px; }
        .place-details { text-align: center; margin-bottom: 32px; }
        .place-details h3 { margin: 0 0 8px; color: #1e293b; font-size: 18px; font-weight: 700; }
        .slogan { margin: 0 0 16px; color: #16a34a; font-size: 14px; font-weight: 500; font-style: italic; }
        .desc { margin: 0 0 24px; color: #475569; font-size: 14px; line-height: 1.6; }
        
        .categories { margin: 24px 0; padding: 24px 0; border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; }
        .badge { display: inline-block; background-color: #f8fafc; color: #475569; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 500; border: 1px solid #e2e8f0; }
        
        .location { margin-top: 24px; color: #475569; font-size: 14px; }
        .location strong { color: #1e293b; display: block; margin-bottom: 4px; }
        
        .button-wrapper { text-align: center; margin: 32px 0; }
        .button { display: inline-block; background-color: #16a34a; color: #ffffff; text-decoration: none; border-radius: 8px; padding: 12px 28px; font-weight: 600; font-size: 14px; letter-spacing: 0.2px; transition: background-color 0.2s; }
        .button:hover { background-color: #15803d; }
        
        .footer { margin-top: 32px; padding-top: 24px; border-top: 1px solid #f1f5f9; text-align: center; }
        .footer p { margin: 0; color: #94a3b8; font-size: 12px; line-height: 1.5; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <a href="{{ $frontendUrl }}" class="logo">
            <img src="{{ $logoUrl }}" alt="Logo" class="logo-icon" />
            <div class="logo-text">Conexión <span class="logo-sub">EcoRisaralda</span></div>
        </a>
        <div class="divider"></div>
    </div>

    <div class="body">
        <h2>Descubrimiento para Ti</h2>
        <p>Encontramos un lugar que coincide con tus intereses.</p>

        @if($place->cover)
        <img class="cover-image" src="{{ url('/api/files/' . $place->cover) }}" alt="{{ $place->name }}" />
        @endif

        <div class="place-details">
            <h3>{{ $place->name }}</h3>

            @if($place->slogan)
            <p class="slogan">"{{ $place->slogan }}"</p>
            @endif

            <p class="desc">{{ Illuminate\Support\Str::limit($place->description, 200) }}</p>

            @if(count($matched) > 0)
            <div class="categories">
                @foreach($matched as $category)
                <span class="badge">{{ $category }}</span>
                @endforeach
            </div>
            @endif

            <div class="location">
                <strong>Ubicación</strong> 
                {{ $place->localization }}
            </div>
        </div>

        <div class="button-wrapper">
            <a href="{{ $placeUrl }}" class="button">Explorar este sitio</a>
        </div>
    </div>

    <div class="footer">
        <p>Recibiste este correo porque tienes notificaciones activas.</p>
        <p style="margin-top: 8px;">© {{ date('Y') }} Conexión EcoRisaralda</p>
    </div>
</div>
</body>
</html>