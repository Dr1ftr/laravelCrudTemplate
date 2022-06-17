<x-sidemenu-layout>

    @push('stylesheets')
        <link rel="stylesheet" href="{{ mix('/css/overview-loan.css') }}">
    @endpush

    <div class="margin">
        <div class="center">
            <table id="dtBasicExample" class="table-requests">
                <thead>
                    <tr>
                        <th>{{ __("Name") }}</th>
                        <th>{{ __("Date: lent out") }}</th>
                        <th>{{ __("Date: to return") }}</th>
                        <th>{{ __("Amount") }}</th>
                        <th>{{ __("Take in loan?") }}</th>
                        <th></th>
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
                                <form method="post" action="{{ route("loan.take-in", $request->loanId) }}"> @csrf
                                    <button class="button2" type="button">{{ __("Take in") }}</button>
                                </form>
                            </td>
                            <td><button class="button3" type="button">{{ __("Details") }}</button></td>
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
        <script src="{{ mix("/ts/loan/take-in.js") }}"></script>
    @endpush

</x-sidemenu-layout>
