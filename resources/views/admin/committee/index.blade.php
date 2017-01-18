@extends('admin.layout')

@section('content')
  <h1 class="page-header">Committees</h1>

  <table class="table table-hover">
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Summary</th>
      <th>Email</th>
      <th></th>
    </tr>

    <?php $i = 1 ?>
    @foreach ($committees as $committee)
      <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $committee->name() }}</td>
        <td>{{ $committee->summary() }}</td>
        <td>{{ (string)$committee->email() }}</td>
        <td><a href="/admin/committee/{{ (string)$committee->committeeId() }}"><span class="glyphicon glyphicon-edit"></span> Edit</a></td>
      </tr>
    @endforeach
  </table>

  <a href="/admin/committee/create" class="btn btn-default">Create new committee</a>
@endsection
