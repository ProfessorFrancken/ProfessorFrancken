@extends('admin.layout')

@section('content')

  <h1>Create committee</h1>

  {!! Form::open(['url' => 'admin/committee']) !!}

    <div class="form-group">
      {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
      {!! Form::text('name', '', ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
      {!! Form::label('email', 'Email (optional):', ['class' => 'control-label']) !!}
      {!! Form::text('email', '', ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
      {!! Form::label('summary', 'Summary:', ['class' => 'control-label']) !!}
      {!! Form::textarea('summary', '', ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
      {!! Form::label('page', 'Commitee page (optional):', ['class' => 'control-label']) !!}
      {!! Form::textarea('page', '', ['class' => 'form-control']) !!}
    </div>

    {!! Form::submit('Create!', ['class' => 'btn btn-primary']) !!}

  {!! Form::close() !!}

  @include('admin._errors')

@endsection
