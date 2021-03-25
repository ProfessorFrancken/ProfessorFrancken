@extends('layout.one-column-layout')
@section('title', "Soundboard - " . $soundboard->name . " - T.F.V. 'Professor Francken'")

@section('content')
    <div class="bg-light p-4 mt-5 pt-0 border">
        {!!
               Form::model($sound, [
                   'url' => action(
                       [\Francken\Association\Soundboards\Http\SoundsController::class, 'update'],
                       ['soundboard' => $soundboard, 'sound' => $sound]
                   ),
                   'method' => 'PUT',
                   'enctype' => 'multipart/form-data'
               ])
        !!}
        
        <h4>Edit {{ $sound->name }} sound</h4>
        @include('association.soundboards._form', ['soundboard' => $soundboard, 'sound' => $sound])

        <x-forms.submit>Update</x-forms.submit>
        {!! Form::close() !!}
    </div>


    {!!
       Form::model(
           $sound,
           [
               'url' => action(
                   [\Francken\Association\Soundboards\Http\SoundsController::class, 'destroy'],
                   ['soundboard' => $sound->soundboard, 'sound' => $sound]
               ),
               'method' => 'post'
           ]
       )
    !!}
    @method('DELETE')
    <p class="mt-2 text-muted d-flex align-items-center justify-content-end">
        Click <button
                  class="btn btn-text px-1"
                  onclick='return confirm("Are you sure you want to remove this sound?");'
              >here</button> to remove this sound.

    </p>
    {!! Form::close() !!}
@endsection
