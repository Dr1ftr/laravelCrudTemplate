<div class="messages-holder fixed left-0 right-0 top-0 w-full flex z-20 justify-center">
    @if( Session::has('msg') ) {{-- only show session message if there is one --}}
        <div class="message-div flex flex-col justify-center items-center w-full min-h-[5rem] max-w-xl bg-mbou-blue-600 text-white text-center p-2 rounded-lg drop-shadow-md">
            <button class="message-close-button absolute top-2 right-2">
                <box-icon class="fill-white hover:opacity-75 active:opacity-60" name="x"></box-icon>
            </button>
            {{ Session::get('msg') }}
        </div>
    @endif
</div>
