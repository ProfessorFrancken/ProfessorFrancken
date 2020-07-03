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

        <h2 class="card-title">Edit {{ $edition->title() }}</h2>

        <div class="form-group">
            {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
            {!! Form::text('title', $edition->title(), ['class' => 'form-control']) !!}
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    {!! Form::label('volume', 'Volume:', ['class' => 'control-label']) !!}
                    {!! Form::number('volume', $edition->volume(), ['class' => 'form-control', 'min' => 1]) !!}
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    {!! Form::label('edition', 'Edition:', ['class' => 'control-label']) !!}
                    {!! Form::number('edition', $edition->edition(), ['class' => 'form-control', 'min' => 1, 'max' => 3]) !!}
                </div>
            </div>
        </div>

        <div class="form-group">
            <p>
                You may optionally reupload the Francken Vrij Pdf
            </p>
            {!! Form::label('pdf', 'Francken Vrij PDF', ['class' => 'control-label']) !!}
            {!! Form::file('pdf', ['class' => 'form-control-file']) !!}
        </div>

        <div class="form-group">
            <p>
                You may optionally reupload the cover image.
                The cover image should have a size of 175x245 pixels.
            </p>
            {!! Form::label('cover', 'Cover', ['class' => 'control-label']) !!}
            {!! Form::file('cover', ['class' => 'form-control-file']) !!}
        </div>

        {!! Form::submit('Update', ['class' => 'btn btn-outline-success']) !!}

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
