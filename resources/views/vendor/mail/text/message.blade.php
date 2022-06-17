@component('mail::layout')
    {{-- Header --}}
    @slot('head')
        @component('mail::header', ['url' => route('dashboard')])
            {{ $header ?? 'Mbou' }}
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('foot')
        @component('mail::footer')
            {{ $footer ?? '' }}
            © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
        @endcomponent
    @endslot
@endcomponent
