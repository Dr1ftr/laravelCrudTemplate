@component('mail::message')

@component('mail::center')
# @lang('mail.loan-accepted', ['name' => $accepter])
@endcomponent

@component('mail::center')
{{ __("mail.loan-start", ["time" => $startTime, 'date' => $startDate]) }}
@endcomponent
@component('mail::center')
{{ __("mail.loan-end", ["time" => $endTime, "date" => $endDate]) }}
@endcomponent


@component('mail::center')

@component('mail::button', ['color' => 'gray', 'classes' => 'blob'])
{{ $itemCount }} {{ $item }}(s)
@endcomponent

@endcomponent

@slot('footer')
@lang('mail.not-meant-for-you')<br>
@lang('mail.not-meant-for-you2')<br><br>
@endslot

@endcomponent
