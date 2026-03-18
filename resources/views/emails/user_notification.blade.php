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
        .message { color: #475569; font-size: 16px; line-height: 1.7; margin: 0 0 32px 0; }
        .button-wrapper { text-align: center; margin: 36px 0; }
        .button { display: inline-block; background-color: #10b981; color: #ffffff; text-decoration: none; border-radius: 999px; padding: 14px 40px; font-weight: 600; font-size: 16px; }
        .alert { background-color: #f0f9ff; border-left: 4px solid #0284c7; border-radius: 8px; padding: 16px; margin: 24px 0; }
        .alert p { margin: 0; color: #0c4a6e; font-size: 13px; line-height: 1.6; }
        .footer-note { color: #64748b; font-size: 14px; line-height: 1.5; margin: 0; }
        .footer { background-color: #f8fafc; padding: 24px 32px; text-align: center; border-top: 1px solid #e2e8f0; }
        .footer p { margin: 0; color: #94a3b8; font-size: 12px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>{{ $subjectLine }}</h2>
    </div>

    <div class="body">
        <p class="message">{{ $messageText }}</p>

        <div class="button-wrapper">
            <a href="{{ $actionUrl }}" class="button">{{ $actionLabel }}</a>
        </div>

        <div class="alert">
            <p>Si no realizaste esta solicitud o no reconoces esta actividad, por favor ignora este correo. Tu cuenta está segura.</p>
        </div>

        <p class="footer-note">Este es un correo automático de Conexion EcoRisaralda. Por favor no respondas a este mensaje.</p>
    </div>

    <div class="footer">
        <p>© 2026 Conexion EcoRisaralda. Todos los derechos reservados.</p>
    </div>
</div>
</body>
</html>
