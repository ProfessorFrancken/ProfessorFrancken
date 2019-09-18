@extends('profile.layout')

@section('content')
    <h2 class="section-header">
        <i class="fa fa-chart-bar text-primary text-center" aria-hidden="true"></i>
        Expenses
    </h2>

    <p class="lead">
        On this page you can find your expenses at Francken.
        Note that due to technical difficulties we only show transactions from the streep system (the fridge).
        These do not include expenses from ordering food and participating in activities.
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
                        €{{ number_format($month['price'], 2) }}
                    </td>
                    <td class="text-right">
                        <a href="{{ action([\Francken\Association\Members\Http\ExpensesController::class, 'show'], [$month['time']->format('Y'), $month['time']->format('m')]) }}">
                            show transactions
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
