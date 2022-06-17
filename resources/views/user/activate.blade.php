<x-guest-layout>
    <div class="h-screen w-screen flex align-middle items-center justify-center flex-col">
        <img class="h-32" src="{{ mix('/img/mbo-utrecht.png') }}" alt="Logo of mbou">

        <form method="post" action="{{ route('user.activate.post', ['userId' => $user->id, 'code' => $code]) }}" class="mx-auto mt-3 self-center align-middle p-10 rounded-lg w-full bg-white drop-shadow-lg max-w-screen-md sm:w-9/12 md:w-8/12 lg:w-7/12 xl:w-5/12 2xl:w-5/12">
            @csrf <!-- {{ csrf_field() }} -->
            <div class="w-full h-full flex flex-col">
                <h1 class="text-2xl">{{ __("Welcome :name", ["name" => $user->getFullName()]) }}</h1>

                <div class="w-full mt-5">
                    <x-jet-label for="password" value="{{ __('Password') }}" />
                    <x-jet-input id="password" name="password" type="password" class="mt-1 w-full" autocomplete="new-password" />
                    <x-jet-input-error for="password" class="mt-2 w-full" />
                </div>

                <div class="w-full mt-5">
                    <x-jet-label for="password_confirmation" value="{{ __('Repeat password') }}" />
                    <x-jet-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 w-full" autocomplete="password" />
                    <x-jet-input-error for="password_confirmation" class="mt-2 w-full" />
                </div>

                <input type="submit" value="{{ __('Activate') }}" class="mt-5 bg p-2 rounded drop-shadow-md hover:focus:drop-shadow mx-auto min-w-1 bg-mbou-blue hover:focus:bg-mbou-blue-600 cursor-pointer text-white">
            </div>
        </form>
    </div>
</x-guest-layout>
