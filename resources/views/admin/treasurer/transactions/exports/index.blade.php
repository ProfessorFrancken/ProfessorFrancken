@extends('admin.layout')
@section('page-title', 'Transactions / Exports')

@section('content')
<p class="lead">
    The table below shows previous deductions made.
    Click the export button to open the data export to excel.
    Use the form on the right to create a new deduction export.<br/>
    To avoid double deductions we only allow to edit or delete the last dedcution.
</p>

<div class="row">
    <div class="col-md-9">
        <div class="card">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-left">Export</th>
                        <th>From</th>
                        <th>Until</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deductions as $deduction)
                    <tr>
                        <td class="d-flex gap-3 text-right justify-content-start">
                            <a class='btn btn-sm btn-outline-primary' href={{ action([\Francken\Treasurer\Http\Controllers\AdminTransactionsExportsController::class, 'show'], ['deduction' => $deduction->id])  }}>
                                Show
                            </a>
                        </td>

                        <td style="font-variant-numeric: tabular-nums">
                            {{ $deduction->previousDeduction()?->tijd }}
                        </td>

                        <td style="font-variant-numeric: tabular-nums">
                            {{ $deduction->tijd }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="card-footer">
                {!! $deductions->links() !!}
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body bg-light">
                {!!
                Form::open([
                'url' => action([
                \Francken\Treasurer\Http\Controllers\AdminTransactionsExportsController::class,
                'store'
                ]),
                'method' => 'POST',
                ])
                !!}


                <div class="mx-2">
                    <x-forms.datetime
                        name="from"
                        label="From"
                        :value="optional($lastDeduction->tijd ?? new \DateTimeImmutable)->format('Y-m-d H:i:s')"
                        disabled
                        help="The start date is based on the last deduction made"
                    />
                </div>

                <div class="mx-2">
                    <x-forms.datetime name="until" label="Until" :value="optional($request->until ?? new \DateTimeImmutable)->format('Y-m-d H:i:s')" />
                </div>

                <x-forms.submit>Create</x-forms.submit>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection
