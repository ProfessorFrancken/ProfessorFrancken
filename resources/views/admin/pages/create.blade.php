@extends('admin.layout')
@section('page-title', 'Pages / create')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body bg-light">
                    {!! Form::model($page, [
                            'url' => action([\Francken\Shared\Http\Controllers\Admin\PagesController::class, 'store']),
                            'method' => 'post',
                            ])
                    !!}

                        @include('admin.pages._form', ['page' => $page])

                        <x-forms.submit>Add page</x-forms.submit>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
