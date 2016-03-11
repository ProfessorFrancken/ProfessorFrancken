@extends('layouts.dashboard')

@section('content')
  <h1 class="page-header">Members</h1>
  
  <table class="table table-hover">
    <tr>
      <th>#</th>
      <th>first name</th>
      <th>last name</th>
      <th></th>
    </tr>

    <?php $i = 1 ?>
    @foreach ($members as $member)
      <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $member->first_name }}</td>
        <td>{{ $member->last_name }}</td>
        <td><a><span class="glyphicon glyphicon-edit"></span> Edit</a></td>
      </tr>
    @endforeach
  </table>

  <h3>Add member</h3>

  <form action="{{ url('admin/member/add-member') }}" method="POST" class="form-horizontal">
    {!! csrf_field() !!}

    <div class="form-group">
      <label class="col-sm-4 control-label">first name</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="first_name">
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-4 control-label">last name</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="last_name">
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-default">Add member</button>
      </div>
    </div>

  </form>
@endsection