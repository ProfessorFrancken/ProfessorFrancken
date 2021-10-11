@extends('admin.layout')
@section('page-title', 'Alumni activity 2022 / Add alumnus')

@section('content')
    <div class="card">
        <div class="card-body">
            {!!
                   Form::model($alumnus, [
                       'url' => action(
                           [\Francken\Association\AlumniActivity\Http\AdminAlumniActivityController::class, 'store'] ,
                       ),
                   ])
            !!}
            @include('admin.association.alumni-activity._form', ['alumnus' => $alumnus])

                <x-forms.submit>Sign up</x-forms.submit>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
