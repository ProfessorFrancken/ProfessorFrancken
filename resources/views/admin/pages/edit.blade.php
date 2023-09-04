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

    {!!
           Form::model(
               $page,
               [
                   'url' => action(
                       [\Francken\Shared\Http\Controllers\Admin\PagesController::class, 'destroy'] ,
                       ['page' => $page]
                   ),
                   'method' => 'post'
               ]
           )
    !!}
    @method('DELETE')
    <p class="mt-2 text-muted d-flex align-items-center justify-content-end">
        Click <button
                  class="btn btn-text px-1"
                  onclick='return confirm("Are you sure you want to remove this page?");'
              >here</button> to remove page.
    </p>
    {!! Form::close() !!}
@endsection
