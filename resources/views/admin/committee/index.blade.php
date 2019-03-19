@extends('admin.layout')
@section('page-title', 'Committees')

@section('content')
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
        <td><a href="{{ action([\Francken\Infrastructure\Http\Controllers\Admin\CommitteeController::class, 'show'], (string) $committee->committeeId()) }}"><span class="glyphicon glyphicon-edit"></span> Edit</a></td>

      </tr>
    @endforeach
  </table>

  <a href="{{ action([\Francken\Infrastructure\Http\Controllers\Admin\CommitteeController::class, 'create']) }}"
     class="btn btn-default"
  >
      Create new committee
  </a>
@endsection
