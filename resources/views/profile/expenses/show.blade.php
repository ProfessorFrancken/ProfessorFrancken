@extends('profile.layout')

@section('content')
    <h4 class="font-weight-bold section-header">
        <i class="fa fa-chart-bar text-primary text-center" aria-hidden="true"></i>
        Expenses in {{ $date }}
    </h4>

    @if (count($byDay) > 0)
        @foreach($byDay as $transactions)
            <div class="card my-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <h5 class='mb-0 font-weight-bold'>
                            {{ $transactions->first()['time']->format('l') }}
                            <small>
                                {{ $transactions->first()['time']->format('j F') }}
                            </small>
                        </h5>
                        <strong>
                            €{{
                                $transactions->reduce(function ($total, $transaction) {
                                    return $total + $transaction['price'];
                                }, 0)
                             }}
                        </strong>

                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                Time
                            </th>
                            <th>
                                Product
                            </th>
                            <th class="text-right">
                                Price
                            </th>
                            <th class="text-right">
                                Deducted on
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td class="text-left">
                                    {{ $transaction['time']->format('H:i') }}
                                </td>
                                <td>
                                    {{ $transaction['product'] }}
                                </td>
                                <td class="text-right">
                                    €{{ $transaction['price'] }}
                                </td>
                                <td class="text-right">
                                    {{ $transaction['deducted_at'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    @else
        <p>
            You did not purchase anything during this period.
        </p>
    @endif
@endsection
