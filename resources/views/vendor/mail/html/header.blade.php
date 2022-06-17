<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@elseif (trim($slot) === 'Mbou')
<img src="{{ URL::asset('img/mbo-utrecht.png') }}" class="mbou-logo" alt="MBO Utrecht logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
