@component('mail::message')

@component('mail::center')
# @lang('mail.loan-closed', ['name' => $closer])
@endcomponent

@component('mail::center')
{{ __("mail.loan-time", ['time' => $time, 'date' => $date]) }}
@endcomponent
@component('mail::center')
{{
    $isLate ?
        __("mail.loan-spare-time", ['time' => $dateDiff]) :
        __("mail.loan-late-time", ['time' => $dateDiff]);
}}
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
