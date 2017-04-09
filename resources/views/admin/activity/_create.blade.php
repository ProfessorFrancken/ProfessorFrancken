  <h4>Create an activity</h4>

  {!! Form::open(['url' => url('admin/activity')]) !!}

  <div class="form-group">
      {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
      {!! Form::text('title', $title, ['class' => 'form-control']) !!}
  </div>

    <div class="form-group">
      {!! Form::label('description', 'Description:', ['class' => 'control-label']) !!}
      {!! Form::text('description', $description, ['class' => 'form-control']) !!}
  </div>

  <div class="form-group">
      {!! Form::label('location', 'Location:', ['class' => 'control-label']) !!}
      {!! Form::text('location', $location, ['class' => 'form-control']) !!}
  </div>

  <div class="form-group">
      {!! Form::label('date', 'Date:', ['class' => 'control-label']) !!}
      {!! Form::text('date', $date, ['class' => 'form-control']) !!}
  </div>

  <div class="form-group">
    {!! Form::label('time', 'Time:', ['class' => 'control-label']) !!}
    {!! Form::text('time', $time, ['class' => 'form-control']) !!}
  </div>

  <div class="form-check">
    {!! Form::label('publish', 'Publish', ['class' => 'form-check-label']) !!}
    <br>
    {!! Form::checkbox('published', '', ['class' => 'form-check-input']) !!}
    Unpublished events are not yet visible on the website
  </div>

  {!! Form::submit('Plan', ['class' => 'btn btn-primary']) !!}

  {!! Form::close() !!}

  @include('admin._errors')