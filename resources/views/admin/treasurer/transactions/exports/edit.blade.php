@extends('admin.layout')
@section('page-title', 'Transactions / Exports')

@section('content')

{!! Form::model(
        $deduction,
        [
            'url' => action([\Francken\Treasurer\Http\Controllers\AdminTransactionsExportsController::class, 'update'], ['deduction' => $deduction]),
            'method' => 'POST',
        ]
)
!!}
    @method('PUT')
<div class="card">
    <div class="card-body bg-light">
        {{ sprintf("%s - %s", $previousDeduction->tijd->format("Y-m-d H:i:s"), $deduction->tijd->format("Y-m-d H:i:s")) }}
    </div>

    <div class="card-body">
        <div class="mx-2">
            <x-forms.datetime name="from" label="From" :value="$previousDeduction->tijd" disabled help="The start date is based on the last deduction made" />
        </div>

        <div class="mx-2">
            <x-forms.datetime name="until" label="Until" :value="optional($deduction->tijd ?? new \DateTimeImmutable)->format('Y-m-d H:i:s')" />
        </div>

    </div>
    <div class="card-footer">
        <x-forms.submit>Save</x-forms.submit>
    </div>
</div>
{!! Form::close() !!}
@endsection
