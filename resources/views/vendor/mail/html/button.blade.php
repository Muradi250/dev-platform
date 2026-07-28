@props([
    'url',
    'color' => 'primary',
    'align' => 'center',
])

<table class="action" align="{{ $align }}" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="{{ $align }}">

<a href="{{ $url }}"
   target="_blank"
   rel="noopener"
   style="
        display:inline-block;
        padding:14px 32px;
        background:#2563eb;
        color:#ffffff;
        text-decoration:none;
        border-radius:8px;
        font-size:16px;
        font-weight:bold;
        font-family:Arial, sans-serif;
   ">
    {!! $slot !!}
</a>

</td>
</tr>
</table>