@extends('layouts.dashboard')

@section('content')
  <h1 class="page-header">Committees</h1>
  
  <table class="table table-hover">
    <tr>
      <th>#</th>
      <th>Committe name</th>
      <th>Committee goal</th>
      <th></th>
    </tr>

    <?php $i = 1 ?>
    @foreach ($committees as $committee)
      <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $committee->name }}</td>
        <td>{{ $committee->goal }}</td>
        <td><a href="/admin/committee/{{ $committee->uuid }}"><span class="glyphicon glyphicon-edit"></span> Edit</a></td>
      </tr>
    @endforeach
  </table>

  <h3>Create committee</h3>

  <form action="{{ url('admin/committee/create-committee') }}" method="POST" class="form-horizontal">
    {!! csrf_field() !!}

    <div class="form-group">
      <label class="col-sm-4 control-label">Committee name</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="inputName">
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-4 control-label">Committee goal</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="inputGoal">
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-default">Create committee</button>
      </div>
    </div>

  </form>
@endsection