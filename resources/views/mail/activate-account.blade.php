@component('mail::message')

@component('mail::center')
# @lang('mail.account-made', ['name' => $name])
@endcomponent

@if (count($roles) > 0) {{-- only show gotten roles: if the user has gotten roles --}}
<br>
@component('mail::center')
@lang('mail.gotten-roles')
@endcomponent

@component('mail::center')
@foreach ($roles as $role) {{-- no indentation because markdown :( --}}
@component('mail::button', ['color' => 'gray', 'classes' => 'blob'])
    {{ $role }}
@endcomponent
@endforeach
@endcomponent
@endif

@component('mail::button', ['url' => route('user.activate', ['userId' => $userId, 'code' => $code]), 'color' => 'blue'])
@lang('mail.activate-account')
@endcomponent

@slot('footer')
@lang('mail.not-meant-for-you')<br>
@lang('mail.not-meant-for-you2')<br><br>
@endslot

@endcomponent
