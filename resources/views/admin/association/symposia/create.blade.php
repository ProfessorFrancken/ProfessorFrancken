@extends('admin.layout')
@section('page-title', 'Symposia / create')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body bg-light">
                    {!! Form::model($symposium, [
                            'url' => action([\Francken\Association\Symposium\Http\AdminSymposiaController::class, 'store']),
                            'method' => 'post',
                            'enctype' => 'multipart/form-data',
                            ])
                    !!}

                        @include('admin.association.symposia._form', ['symposium' => $symposium])

                        <x-forms.submit>Add symposium</x-forms.submit>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
