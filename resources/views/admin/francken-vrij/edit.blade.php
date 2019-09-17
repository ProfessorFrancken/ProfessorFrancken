@extends('admin.layout')
@section('page-title', 'Francken Vrij / ' . $edition->title())

@section('content')
    <div class="card my-3">
        {!! Form::open(['url' => "/admin/association/francken-vrij/" . $edition->getId(), 'files' => true, 'method' => 'put', 'class' => 'card-body']) !!}

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

    @include('admin._errors')

    <div class="card my-3">
        <div class="card-body">
            <h3 class="card-title">
                Other actions
            </h3>

            <p>
                Archiving a Francken Vrij will directly remove it from our datbase. The associated files (pdf and cover image) won't be removed.
            </p>

            {!! Form::open(['url' => '/admin/association/francken-vrij/' . $edition->getId(), 'method' => 'delete']) !!}
            <button class="btn btn-outline-danger">
                <i class="fa fa-trash-o" aria-hidden="true"></i>
                Archive
            </button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
