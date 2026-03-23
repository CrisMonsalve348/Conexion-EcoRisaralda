@props(['url'])
@php
$frontendUrl = rtrim(config('app.frontend_url', config('app.url')), '/');
$logoUrl = $frontendUrl . '/images/Pagina_inicio/nature-svgrepo-com.svg';
@endphp
<tr>
  <td class="header">
    <a href="{{ $url }}" style="text-decoration: none; display: inline-flex; align-items: center; gap: 10px;">
      <img src="{{ $logoUrl }}" alt="Logo" style="width: 32px; height: 32px;" />
      <div style="font-size: 18px; font-weight: 700; color: #1e293b; letter-spacing: -0.3px; text-align: left; line-height: 1.2;">
        Conexión <span style="font-size: 13px; color: #16a34a; font-weight: 600; display: block;">EcoRisaralda</span>
      </div>
    </a>
    <div style="width: 40px; height: 2px; background-color: #e2e8f0; margin: 24px auto 0;"></div>
  </td>
</tr>
