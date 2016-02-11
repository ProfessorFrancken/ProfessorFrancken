@extends('layouts.dashboard')

@section('content')
  <h1>Committees</h1>
  <table class="table table-hover">
    <tr>
      <th>#</th>
      <th>Committe name</th>
      <th>Committee goal</th>
    </tr>
    @foreach ($committees as $committee)
      <tr>
        <td>1</td>
        <td>{{ $committee->name }}</td>
        <td>{{ $committee->goal }}</td>
      </tr>
    @endforeach
  </table>

  <!-- TODO: Met beetje php tabel opvullen uit database! -->
@endsection