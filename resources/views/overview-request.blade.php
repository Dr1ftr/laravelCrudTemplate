<x-sidemenu-layout>

    @push('stylesheets')
        <link rel="stylesheet" href="{{ mix('/css/overview-request.css') }}">
    @endpush

    <div class="margin">
        <div class="center">
            <table id="dtBasicExample" class="table-requests">
                <thead>
                    <tr>
                        <th>{{ __("Name") }}</th>
                        <th>{{ __("Date: start") }}</th>
                        <th>{{ __("Date: end") }}</th>
                        <th>{{ __("Amount") }}</th>
                        <th>{{ __("Accept loan request?") }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                        <tr>
                            <td>{{$request->firstName . " " .  $request->lastName}}</td>
                            <td>{{$request->loaning_start}}</td>
                            <td>{{$request->loaning_end}}</td>
                            <td>{{$request->amount}}</td>
                            <td>
                                <form method="post" action="{{ route('loan.request.accept', $request->requestId) }}"> @csrf
                                    <button class="button" type="button">{{ __("Accept") }}</button>
                                </form>
                                <form method="post" action="{{ route('loan.request.reject', $request->requestId) }}"> @csrf
                                    <button class="button2" type="button">{{ __("Reject") }}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <span>
                {{$requests->links()}}
            </span>
        </div>
    </div>

    @push('scripts')
        <script src="{{ mix("/ts/loan/accept-request.js") }}"></script>
        <script src="{{ mix("/ts/loan/reject-request.js") }}"></script>
    @endpush

</x-sidemenu-layout>
