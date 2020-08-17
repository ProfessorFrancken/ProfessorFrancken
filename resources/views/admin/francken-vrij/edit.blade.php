@extends('admin.layout')
@section('page-title', 'Francken Vrij / ' . $edition->title())

@section('content')
    <div class="card my-3">
        {!!
           Form::open([
               'url' => action(
                   [\Francken\Association\FranckenVrij\Http\AdminFranckenVrijController::class, 'destroy'],
                   ['edition' => $edition]
               ),
               'files' => true,
               'method' => 'PUT',
               'class' => 'card-body'
           ])
        !!}


        <x-forms.text name="title" label="Title" :value="$edition->title()" />

        <div class="row">
            <div class="col-sm-6">
                <x-forms.text name="volume" label="Volume" :value="$edition->volume()" />
            </div>

            <div class="col-sm-6">
                <x-forms.text name="edition" label="Edition" :value="$edition->edition()" />
            </div>
        </div>

        <x-forms.form-group name="pdf" label="Fancken Vrij Pdf">
            {!! Form::file('pdf', ['class' => 'form-control-file']) !!}

            <x-slot name="help">
                You may optionally reupload the Francken Vrij Pdf
            </x-slot>
        </x-forms.form-group>

        <x-forms.form-group name="cover" label="Cover">
            {!! Form::file('cover', ['class' => 'form-control-file']) !!}

            <x-slot name="help">
                You may optionally reupload the cover image.
                The cover image should have a size of 175x245 pixels.
            </x-slot>
        </x-forms.form-group>

        <x-forms.submit>Update</x-forms.submit>

        {!! Form::close() !!}

    </div>

    {!!
       Form::model(
           $edition,
           [
               'url' => action(
                   [\Francken\Association\FranckenVrij\Http\AdminFranckenVrijController::class, 'destroy'],
                   ['edition' => $edition]
               ),
               'method' => 'post'
           ]
       )
    !!}
    @method('DELETE')
    <p class="mt-2 mb-0 text-muted d-flex align-items-center justify-content-end">
        Click <button
                  type="submit"
                  class="btn btn-text px-1"
                  onclick='return confirm("Are you sure you want to remove this partner?");'
              >here</button> to remove this francken vrij.
    </p>
    <p class="mt-0 text-muted d-flex align-items-center justify-content-end">
        Note this only removes the francken vrij from the database, it does not remove its associated files.
    </p>
    {!! Form::close() !!}
@endsection
