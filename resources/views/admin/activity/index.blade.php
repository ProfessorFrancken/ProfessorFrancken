@extends('admin.layout')
@section('page-title', 'Activities')

@section('content')
  <table class="table table-hover">
    <tr>
      <th>#</th>
      <th>Title</th>
      <th>Description</th>
      <th></th>
    </tr>

      <tr>
        <td>1</td>
        <td>Crash and Compile</td>
        <td>Beer and programming!</td>
        <td><a href="#"><span class="glyphicon glyphicon-edit"></span> Edit</a></td>
      </tr>
  </table>

  <h3>Create an activity</h3>

  <form action="{{ url('') }}" method="POST">
    {!! csrf_field() !!}

    <div class="form-group">
      <label class="control-label">Title</label>
      <input type="text" class="form-control" name="title">
    </div>

    <div class="form-group">
      <label class="control-label">Description</label>
      <input type="text" class="form-control" name="description">
    </div>

    <div class="form-group">
      <label class="control-label">Location</label>
      <input type="text" class="form-control" name="location">
    </div>

    <div class="form-group">
      <label class="control-label">Date-time (dd/mm/yyyy hh:mm)</label>
      <input type="text" class="form-control" name="date-time">
    </div>

    <div class="checkbox">
      <label>
        <input type="checkbox"> Is published?
      </label>
    </div>

    <button type="submit" class="btn btn-default">Create Activity</button>

  </form>
@endsection
