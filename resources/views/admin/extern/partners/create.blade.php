@extends('admin.layout')
@section('page-title', 'Partners / Add a new partner')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body bg-light">
                    {!!
                       Form::model($partner, [
                           'url' => action([\Francken\Extern\Http\AdminPartnersController::class, 'store']),
                           'method' => 'POST',
                           'enctype' => 'multipart/form-data'
                       ])
                    !!}
                        @include('admin.extern.partners._form', ['partner' => $partner])

                        <x-forms.submit>Add</x-forms.submit>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
