@extends('admin.layout')
@section('page-title', 'Transactions / ' . $transaction->id . ' / Edit')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    {!!
                       Form::model($transaction, [
                           'url' => action([\Francken\Treasurer\Http\Controllers\AdminTransactionsController::class, 'update'], ['transaction' => $transaction]),
                           'method' => 'PUT',
                       ])
                    !!}

                        @include('admin.treasurer.transactions._form', ['transaction' => $transaction])

                        <x-forms.submit>Save</x-forms.submit>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
