@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'ISPI')
<img src="https://i.imgur.com/lgDwuIg.png" style="width: 20rem; height: auto;" class="logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
