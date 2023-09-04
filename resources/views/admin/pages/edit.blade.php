@extends('admin.layout')
@section('page-title', $page->title . ' / Edit')

@section('content')
    <div class="card">
        <div class="card-body">
            {!!
                   Form::model($page, [
                       'url' => action(
                           [\Francken\Shared\Http\Controllers\Admin\PagesController::class, 'update'], ['page' => $page]
                       ),
                       'method' => 'PUT',
                   ])
            !!}
                @include('admin.pages._form', ['page' => $page])

                <x-forms.submit>Save</x-forms.submit>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
