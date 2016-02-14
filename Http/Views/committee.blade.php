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
        <td><a href="/admin/committee/add-member/{{ $committee->uuid }}"><span class="glyphicon glyphicon-edit"></span> Edit</a></td>
      </tr>
    @endforeach
  </table>

  <a class="btn btn-default" role="button" href="/admin/committee/create-committee">Create new committee</a>

@endsection