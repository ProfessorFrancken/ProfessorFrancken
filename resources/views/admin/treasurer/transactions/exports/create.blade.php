@extends('admin.layout')
@section('page-title', 'Transactions / Exports / Create')

@section('content')

<div class="row">
    <div class="col">
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
                    <x-forms.datetime name="from" label="From" :value="optional($request->from ?? new \DateTimeImmutable)->format('Y-m-d H:i:s')" />
                </div>

                <div class="mx-2">
                    <x-forms.datetime name="until" label="Until" :value="optional($request->until ?? new \DateTimeImmutable)->format('Y-m-d H:i:s')" />
                </div>

                <x-forms.submit>Export</x-forms.submit>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
