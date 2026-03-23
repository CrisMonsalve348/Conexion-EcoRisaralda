<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
<title>{{ config('app.name', 'Conexion EcoRisaralda') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
<style>
body {
  margin: 0;
  padding: 40px 20px;
  background-color: #ffffff;
  color: #1e293b;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}
.wrapper {
  width: 100%;
  background-color: #ffffff;
}
.content {
  width: 100%;
}
.header {
  padding: 0 0 32px 0;
  text-align: center;
}
.inner-body {
  width: 500px;
  max-width: 500px;
  background-color: #ffffff;
}
.content-cell {
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  font-size: 15px;
  line-height: 1.6;
  color: #1e293b;
}
.content-cell h1 {
  font-size: 20px !important;
  font-weight: 700 !important;
  color: #1e293b !important;
  text-align: center;
  margin-bottom: 24px;
}
.content-cell p {
  color: #475569;
  margin-bottom: 16px;
  text-align: center;
}
.subcopy {
  border-top: 1px solid #f1f5f9;
  margin-top: 32px;
  padding-top: 24px;
  font-size: 13px;
  color: #64748b;
  text-align: center;
}
.footer {
  width: 500px;
  max-width: 500px;
  margin-top: 32px;
  padding-top: 24px;
  border-top: 1px solid #f1f5f9;
  color: #94a3b8;
  font-size: 12px;
  text-align: center;
  line-height: 1.5;
}
.button {
  display: inline-block;
  background-color: #16a34a;
  color: #ffffff !important;
  text-decoration: none;
  border-radius: 8px;
  padding: 12px 28px;
  font-weight: 600;
  font-size: 14px;
  letter-spacing: 0.2px;
  transition: background-color 0.2s;
}
.button:hover { background-color: #15803d; }
.button-primary { background-color: #16a34a; }
.button-success { background-color: #16a34a; }
.button-error { background-color: #ef4444; }

@media only screen and (max-width: 600px) {
  .inner-body,
  .footer {
    width: 100% !important;
  }
}
@media only screen and (max-width: 500px) {
  .button {
    width: 100% !important;
    text-align: center !important;
  }
}
</style>
{!! $head ?? '' !!}
</head>
<body>
<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
  <tr>
    <td align="center">
      <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
        {!! $header ?? '' !!}
        <tr>
          <td class="body" width="100%" cellpadding="0" cellspacing="0" style="border: hidden !important;">
            <table class="inner-body" align="center" width="500" cellpadding="0" cellspacing="0" role="presentation">
              <tr>
                <td class="content-cell">
                  {!! Illuminate\Mail\Markdown::parse($slot) !!}
                  {!! $subcopy ?? '' !!}
                </td>
              </tr>
            </table>
          </td>
        </tr>
        {!! $footer ?? '' !!}
      </table>
    </td>
  </tr>
</table>
</body>
</html>
