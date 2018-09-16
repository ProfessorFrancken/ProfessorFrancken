@extends('profile.layout')

@section('content')
    <h2 class="section-header">
        <i class="fa fa-bar-chart text-primary text-center" aria-hidden="true"></i>
        Finances
    </h2>

    <p class="lead">
        On this page you can find your expenses at Francken.
        Note that due to technical difficulties we only show transactions from the streep system (the fridge).
        These do not include expenses from ordering foot and participating in activities.
    </p>

    <p>
        Click the show transactions link to show all transactions made during said month.
    </p>

    <table class="table">
        <thead>
            <tr>
                <th>
                    Month
                </th>
                <th class="text-right">
                    Costs this month
                </th>
                <th class="text-right">
                    Transactions
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($perMonth as $month)
                <tr>
                    <td>
                        {{ $month['time']->format('Y - F') }}
                    </td>
                    <td class="text-right">
                        €{{ $month['price'] }},-
                    </td>
                    <td class="text-right">
                        <a href="/profile/finances/{{ $month['time']->format('Y/m') }}">
                            show transactions
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
