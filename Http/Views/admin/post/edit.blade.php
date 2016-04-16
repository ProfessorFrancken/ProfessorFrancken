@extends('layouts.dashboard')

@section('content')

<h1>Create committee</h1>

{!! Form::model($post, ['route' => ['post.update', $post->uuid, 'method' => 'put']) !!}

  <div class="form-group">
    {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
    {!! Form::text('title', '', ['class' => 'form-control']) !!}
  </div>

  <div class="form-group">
    {!! Form::label('content', 'Content:', ['class' => 'control-label']) !!}
    {!! Form::textarea('content', '', ['class' => 'form-control']) !!}
  </div>

  <div class="form-group">
    {!! Form::label('published_at', 'Published at:', ['class' => 'control-label']) !!}
    {!! Form::date('published_at', \Carbon\Carbon::now(), ['class' => 'form-control']) !!}    
  </div>

  {!! Form::submit('Create!', ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}

@endsection
