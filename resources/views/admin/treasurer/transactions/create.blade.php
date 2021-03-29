@extends('admin.layout')
@section('page-title', 'Transactions / Add a new transaction')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body bg-light">
                    {!!
                       Form::model($transaction, [
                           'url' => action([\Francken\Treasurer\Http\Controllers\AdminTransactionsController::class, 'store']),
                           'method' => 'POST',
                       ])
                    !!}
                        @include('admin.treasurer.transactions._form', ['transaction' => $transaction])

                        <x-forms.submit>Add</x-forms.submit>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
