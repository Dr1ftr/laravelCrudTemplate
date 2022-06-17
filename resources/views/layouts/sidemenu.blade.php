<x-app-layout>
    {{-- repush stylesheet stack inside of this layout to the x-app-layout --}}
@push('stylesheets')
    <link rel="stylesheet" href="{{ mix('/css/sidemenu.css') }}">
@endpush

@push('defer scripts')
    <script src="{{ mix('ts/sidemenu.js') }}" defer></script>
@endpush

    {{-- if a header slot has been used, pass it through to the x-app-layout --}}
@if (isset($header))
    <x-slot name="header">
        {{ $header }}
    </x-slot>
@endif

    <div class="flex relative w-full h-full">
        <div class="sidemenu">
            <div class="sidemenu-content">
                <button class="sidemenu-item sidemenu-button cursor-pointer highlighted">
                    <box-icon name="menu" size="sm" />
                </button>
                <div class="sidemenu-group">
                    <a href="{{ route('dashboard') }}" class="sidemenu-item {{ Route::currentRouteName() == 'dashboard' ? 'highlighted' : '' }}">
                        <box-icon name="home" size="sm"></box-icon>
                        <p>{{ __("Home") }}</p>
                    </a>
                    {{-- <!-- example -->
                    <a href="{{ route('login') }}" class="sidemenu-item {{ Route::currentRouteName() == 'login' ? 'highlighted' : '' }}">
                        <span class="absolute top-0 left-0 w-2 h-2 mt-2 ml-2 bg-indigo-500 rounded-full"></span> <!-- example blue dot thing -->
                        <box-icon name="message-alt-detail" size="sm"></box-icon>
                        <p>{{ __("Login (example)") }}</p>
                    </a> --}}
                </div>
                {{--Article section --}}
                <div class="sidemenu-group">
                    @if( Auth::user()->hasARole('student', 'super-user') )
                        <a href="{{ route('show.articles') }}" class="sidemenu-item {{ Route::currentRouteName() == 'show.articles' ? 'highlighted' : '' }}">
                            <box-icon name="cart-add" type="solid" size="m"></box-icon>
                            <p>{{ __("Request articles") }}</p>
                        </a>
                    @endif
                    @if( Auth::user()->hasARole('warehouse-admin', 'financial-admin') )
                        <a href="{{ route('viewFA.articles') }}" class="sidemenu-item {{ Route::currentRouteName() == 'viewFA.articles' ? 'highlighted' : '' }}">
                            <box-icon name="cart-add" type="solid" size="m"></box-icon>
                            <p>{{ __("Articles") }}</p>
                        </a>
                    @endif
                </div>

                <div class="sidemenu-group">
                    @if( Auth::user()->hasARole('super-user','warehouse-admin') )
                        <a href="{{ route('overview-loan') }}" class="sidemenu-item   {{ Route::currentRouteName() == 'overview-loan' ? 'highlighted' : '' }}">
                            <box-icon name='file'></box-icon>
                            <p>{{ __("Loans") }}</p>
                        </a>

                        <a href="{{ route('request.view') }}" class="sidemenu-item   {{ Route::currentRouteName() == 'request.view' ? 'highlighted' : '' }}">
                            <box-icon name='book-add'></box-icon>
                            <p>{{ __("Loan Requests") }}</p>
                        </a>
                    @endif


                {{-- Admin section --}}
                <div class="sidemenu-group">
                    @if( Auth::user()->hasRole('super-user') )
                        <a href="{{ route('user.create') }}" class="sidemenu-item {{ Route::currentRouteName() == 'user.create' ? 'highlighted' : '' }}">
                            <box-icon name="user-plus" type="solid" size="sm"></box-icon>
                            <p>{{ __("Create User") }}</p>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

        <!-- page content -->
        <div class="w-full ml-16">
            {{ $slot }}
        </div>
    </div>

</x-app-layout>