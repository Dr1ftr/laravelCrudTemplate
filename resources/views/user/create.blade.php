<x-sidemenu-layout>

@push('stylesheets')
    <link rel="stylesheet" href="{{ mix('modules/choicesjs/choices.min.css') }}" />
    <link rel="stylesheet" href="{{ mix('css/create-user.css') }}" />
@endpush

@push('scripts')
    <script src="{{ mix('modules/choicesjs/choices.min.js') }}"></script>
    <script>
        document.user_roles = @js($roles); {{-- roles array --}}
        document.previously_selected_user_roles = @js(old('roles')); {{-- previously selected roles --}}

        document.academies = @js($academies); {{-- academies array --}}
        document.previously_selected_academy = @js(old('academy')); {{-- previously selected academy --}}
    </script>
    <script src="{{ mix('js/create-user_choices-setup.js') }}"></script>
@endpush

    <form method="post" action="{{ route('user.create.post') }}" class="mx-auto mt-2 p-10 rounded-lg w-full bg-white drop-shadow-lg max-w-screen-md sm:w-9/12 md:w-8/12 lg:w-7/12 xl:w-5/12 2xl:w-5/12">
        @csrf <!-- {{ csrf_field() }} -->
        <div class="w-full h-full flex flex-col">
            <h1 class="text-2xl">{{ __('Create an user') }}</h1>

            <!-- Name -->
            <div class="flex w-full mt-5">
                <div class="basis-4/12">
                    <x-jet-label for="firstName" value="{{ __('Firstname') }}" />
                    <x-jet-input id="firstName" name="firstName" type="text" class="mt-1 w-full rounded-none rounded-l-lg" value="{{ old('firstName') }}" autocomplete="given-name" />
                    <x-jet-input-error for="firstName" class="mt-2 w-full" />
                </div>

                <div class="basis-3/12">
                    <x-jet-label for="infix" value="{{ __('Infix') }}" />
                    <x-jet-input id="infix" name="infix" type="text" class="mt-1 w-full rounded-none" value="{{ old('infix') }}" autocomplete="additional-name" />
                    <x-jet-input-error for="infix" class="mt-2 w-full" />
                </div>

                <div class="basis-5/12">
                    <x-jet-label for="lastName" value="{{ __('Lastname') }}" />
                    <x-jet-input id="lastName" name="lastName" type="text" class="mt-1 w-full rounded-none rounded-r-lg" value="{{ old('lastName') }}" autocomplete="family-name" />
                    <x-jet-input-error for="lastName" class="mt-2 w-full" />
                </div>
            </div>

            <div class="w-full mt-5">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" name="email" type="text" class="mt-1 w-full" value="{{ old('email') }}" autocomplete="email" />
                <x-jet-input-error for="email" class="mt-2 w-full" />
            </div>
            
            <div class="w-full mt-5">
                <x-jet-label for="academy-choices" value="{{ __('Academy') }}" />
                <select name="academy" id="academy-choices"></select>
            </div>

            <div class="w-full mt-5">
                <x-jet-label for="role-choices" value="{{ __('Roles') }}" />
                <select name="roles[]" multiple id="role-choices"></select>
            </div>

            <input type="submit" value="{{ __('Create') }}" class="mt-5 bg p-2 rounded drop-shadow-md hover:focus:drop-shadow mx-auto min-w-1 bg-mbou-blue hover:focus:bg-mbou-blue-600 cursor-pointer text-white">
        </div>
    </form>

</x-sidemenu-layout>
