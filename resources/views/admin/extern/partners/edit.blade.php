@extends('admin.layout')
@section('page-title', 'Partners / ' . $partner->name . ' / Edit')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body bg-light">
                    {!!
                       Form::model($partner, [
                           'url' => action([\Francken\Extern\Http\AdminPartnersController::class, 'update'], ['partner' => $partner]),
                           'method' => 'PUT',
                           'enctype' => 'multipart/form-data'
                       ])
                    !!}

                        @include('admin.extern.partners._form', ['partner' => $partner])

                        <x-forms.submit>Save</x-forms.submit>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
