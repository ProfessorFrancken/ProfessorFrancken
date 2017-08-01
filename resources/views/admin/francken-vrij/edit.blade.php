@extends('admin.layout')

@section('content')
    <h1 class="page-header">Edit {{ $edition->title() }}</h1>

    {!! Form::open(['url' => "/admin/association/francken-vrij/" . $edition->getId(), 'files' => true, 'method' => 'put']) !!}

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
        {!! Form::file('pdf') !!}
    </div>

    {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}

    @include('admin._errors')

    {!! Form::open(['url' => '/admin/association/francken-vrij/' . $edition->getId(), 'method' => 'delete']) !!}
    <button class="btn btn-danger">
        <i class="fa fa-trash-o" aria-hidden="true"></i>
        Archive
    </button>
    {!! Form::close() !!}
@endsection
