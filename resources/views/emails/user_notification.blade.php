@php
$frontendUrl = rtrim(config('app.frontend_url', config('app.url')), '/');
$logoUrl = $frontendUrl . '/images/Pagina_inicio/nature-svgrepo-com.svg';
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
        .body p { color: #475569; font-size: 15px; line-height: 1.6; margin: 0 0 20px; text-align: center; }
        .button-wrapper { text-align: center; margin: 32px 0; }
        .button { display: inline-block; background-color: #16a34a; color: #ffffff; text-decoration: none; border-radius: 8px; padding: 12px 28px; font-weight: 600; font-size: 14px; letter-spacing: 0.2px; transition: background-color 0.2s; }
        .button:hover { background-color: #15803d; }
        .alert { margin: 24px 0; padding-top: 24px; border-top: 1px solid #f1f5f9; text-align: center; }
        .alert p { margin: 0; color: #64748b; font-size: 13px; }
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
        <h2>{{ $subjectLine }}</h2>
        
        <p>{{ $messageText }}</p>

        <div class="button-wrapper">
            <a href="{{ $actionUrl }}" class="button">{{ $actionLabel }}</a>
        </div>

        <div class="alert">
            <p>Si no realizaste esta solicitud, por favor ignora este correo. Tu cuenta está segura.</p>
        </div>
    </div>

    <div class="footer">
        <p>Este es un correo automático. No respondas a este mensaje.</p>
        <p style="margin-top: 8px;">© {{ date('Y') }} Conexión EcoRisaralda</p>
    </div>
</div>
</body>
</html>
