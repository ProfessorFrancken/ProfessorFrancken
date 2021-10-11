@extends('admin.layout')
@section('page-title', 'Alumni activity 2022 / ' . $alumnus->fullname . '/ Edit alumni')

@section('content')
    <div class="card">
        <div class="card-body">
            {!!
                   Form::model($alumnus, [
                       'url' => action(
                           [\Francken\Association\AlumniActivity\Http\AdminAlumniActivityController::class, 'update'] ,
                           ['alumnus' => $alumnus]
                       ),
                       'method' => 'PUT',
                   ])
            !!}
            @include('admin.association.alumni-activity._form', ['alumnus' => $alumnus])

                <x-forms.submit>Save sign up</x-forms.submit>
            {!! Form::close() !!}
        </div>
    </div>

        {!!
               Form::model(
                   $alumnus,
                   [
                       'url' => action(
                           [\Francken\Association\AlumniActivity\Http\AdminAlumniActivityController::class, 'destroy'] ,
                           ['alumnus' => $alumnus]
                       ),
                       'method' => 'post'
                   ]
               )
        !!}
        @method('DELETE')
        <p class="mt-2 text-muted d-flex align-items-center justify-content-end">
            Click <button
                      class="btn btn-text px-1"
                      onclick='return confirm("Are you sure you want to remove sign up?");'
                  >here</button> to remove sign up.
        </p>
        {!! Form::close() !!}
@endsection
