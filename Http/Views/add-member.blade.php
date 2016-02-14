@extends('layouts.dashboard')



@section('content')
  <h1 class="page-header">{{ $committee->name }}</h1>


  <h3>General info</h3>
  <form method="POST" class="form-horizontal">
    {!! csrf_field() !!}

    <div class="form-group">
      <label class="col-sm-3 control-label">Committee name</label>
      <div class="col-sm-9">
        <p class="form-control-static">{{ $committee->name }} <a href="#"><span class="glyphicon glyphicon-edit"></span></a></p>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label">Committe goal</label>
      <div class="col-sm-9">
        <p class="form-control-static">{{ $committee->goal }} <a href="#"><span class="glyphicon glyphicon-edit"></span></a></p>
      </div>
    </div>

    <div class="col-sm-9 col-sm-offset-3">
      <button type="submit" class="btn btn-default">Edit</button>
    </div>
  </form>

  <h3>Members</h3>
  <table class="table table-hover">
    <tr>
      <th>#</th>
      <th>Last name</th>
      <th>First name</th>
    </tr>

    {{--example--}}
    <tr>
      <td>1</td>
      <td>Boer</td>
      <td>Mark</td>
    </tr>
  </table>

  <h3>Committee web page</h3>
  <textarea class="form-control" row="10"></textarea>

@endsection