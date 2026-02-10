@props(['url'])
<tr>
  <td class="header">
    <a href="{{ $url }}" style="display: inline-block; color: #ffffff; font-size: 18px; font-weight: 700; letter-spacing: 0.5px; text-decoration: none;">
      {!! $slot !!}
    </a>
  </td>
</tr>
