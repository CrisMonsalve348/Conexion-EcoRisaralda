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
  padding: 0;
  background-color: #ecfdf5;
  color: #0f172a;
}
.wrapper {
  width: 100%;
  background-color: #ecfdf5;
}
.content {
  width: 100%;
}
.header {
  background-color: #16a34a;
  padding: 24px 28px;
  text-align: left;
}
.inner-body {
  width: 570px;
  max-width: 570px;
  background-color: #ffffff;
  border: 1px solid #d1fae5;
  border-radius: 18px;
  overflow: hidden;
}
.content-cell {
  padding: 28px;
  font-family: "Segoe UI", Arial, sans-serif;
  font-size: 15px;
  line-height: 1.6;
  color: #0f172a;
}
.subcopy {
  border-top: 1px solid #e2e8f0;
  margin-top: 20px;
  padding-top: 16px;
  font-size: 13px;
  color: #475569;
}
.footer {
  width: 570px;
  max-width: 570px;
  margin-top: 16px;
  color: #64748b;
  font-size: 12px;
}
.button {
  display: inline-block;
  padding: 12px 24px;
  background-color: #16a34a;
  border-radius: 999px;
  color: #ffffff !important;
  text-decoration: none;
  font-weight: 600;
}
.button-primary {
  background-color: #16a34a;
}
.button-success {
  background-color: #10b981;
}
.button-error {
  background-color: #ef4444;
}
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
            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
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
