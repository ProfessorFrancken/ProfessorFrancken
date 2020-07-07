@extends('profile.layout')

@section('content')
    <h4 class="font-weight-bold section-header">
        <i class="fa fa-chart-bar text-primary text-center" aria-hidden="true"></i>
        Expenses
    </h4>

    <p class="lead">
        On this page you can find your expenses at Francken.
        Note that due to technical difficulties we only show transactions from the streep system (the fridge).
        These do not include expenses from ordering food and participating in activities.
    </p>

    <p>
        Click the show transactions link to show all transactions made during said month.
    </p>

    <div class="card">
        <table class="table table-hover">
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
                            <a href="{{ action([\Francken\Association\Members\Http\ExpensesController::class, 'show'], [$month['time']->format('Y'), $month['time']->format('m')]) }}">
                                {{ $month['time']->format('Y - F') }}
                            </a>
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
    </div>
@endsection
