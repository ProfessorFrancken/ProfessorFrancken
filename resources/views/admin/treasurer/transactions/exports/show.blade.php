@extends('admin.layout')
@section('page-title', 'Transactions / Exports')

@section('content')
        <div class="card">
            <div class="card-body bg-light">
                {{ sprintf("%s - %s", $previousDeduction->tijd->format("Y-m-d H:i:s"), $deduction->tijd->format("Y-m-d H:i:s")) }}
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>initialen</th>
                        <th>tussenvoegsel</th>
                        <th>achternaam</th>
                        <th>rekenignnummer</th>
                        <th>plaats_bank</th>
                        <th>adres</th>
                        <th>plaats</th>
                        <th>land</th>
                        <th>start_lidmaatschap</th>
                        <th>totale_kosten</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->initialen }}</td>
                        <td>{{ $transaction->tussenvoegsel }}</td>
                        <td>{{ $transaction->achternaam }}</td>
                        <td>{{ $transaction->rekeningnummer }}</td>
                        <td>{{ $transaction->plaats_bank }}</td>
                        <td>{{ $transaction->adres }}</td>
                        <td>{{ $transaction->plaats }}</td>
                        <td>{{ $transaction->land }}</td>
                        <td>{{ $transaction->start_lidmaatschap }}</td>
                        <td>€{{ number_format($transaction->totale_kosten, 2, ",", "") }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="10">
                            Total
                        </th>
                        <th colspan="1">
                            €{{ number_format($transactions->map(fn ($d) => floatval($d->totale_kosten))->sum(), 2, ",", "") }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>

@if ($canEdit)
    {!!
           Form::model(
               $deduction,
               [
                   'url' => action(
                       [\Francken\Treasurer\Http\Controllers\AdminTransactionsExportsController::class, 'destroy'],
                       ['deduction' => $deduction]
                   ),
                   'method' => 'post'
               ]
           )
    !!}
    @method('DELETE')
    <p class="mt-2 text-muted d-flex align-items-center justify-content-end">
        Click <button
                  class="btn btn-text px-1"
                  onclick='return confirm("Are you sure you want to remove this?");'
              >here</button> to remove deduction.
    </p>
    {!! Form::close() !!}
@endif
@endsection

@section('actions')
    <div class="d-flex align-items-end gap-3">
        <a href="{{ action([\Francken\Treasurer\Http\Controllers\AdminTransactionsExportsController::class, 'export'], ['deduction' => $deduction]) }}"
           class="btn btn-primary"
        >
            <i class="fas fa-cloud-download-alt"></i>
            Export
        </a>
        @if ($canEdit)
        <a href="{{ action([\Francken\Treasurer\Http\Controllers\AdminTransactionsExportsController::class, 'edit'], ['deduction' => $deduction]) }}"
           class="btn btn-primary"
        >
            <i class="fas fa-edit"></i>
            Edit
        </a>
        @endif
    </div>
@endsection
