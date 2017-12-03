@extends('my-francken.index')

@section('content')
    <h2 class="section-header">
        <i class="fa fa-bar-chart text-primary text-center" aria-hidden="true"></i>
        Finances in {{ $date }}
    </h2>

    @if (count($byDay) > 0)
        @foreach($byDay as $transactions)
            <div class="card my-3">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>
                            {{ $transactions->first()['time']->format('l') }}
                            <small>
                                {{ $transactions->first()['time']->format('j F') }}
                            </small>
                        </h3>
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
