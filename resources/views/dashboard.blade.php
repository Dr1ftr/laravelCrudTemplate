<x-sidemenu-layout>
@push('stylesheets')
    {{-- Dashboard specific styling (blue background instead of a gray one) --}}
    <link rel="stylesheet" href="{{ mix('/css/dashboard.css') }}">
@endpush

</x-sidemenu-layout>
