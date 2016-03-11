@extends('layouts.dashboard')


@section('content')
<h1 class="page-header">Overview</h1>

<div class="row placeholders">
  <div class="col-xs-6 col-sm-3 placeholder">
    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" class="img-responsive" alt="Generic placeholder thumbnail" height="200" width="200">
    <h4>Label</h4>
    <span class="text-muted">Something else</span>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" class="img-responsive" alt="Generic placeholder thumbnail" height="200" width="200">
    <h4>Label</h4>
    <span class="text-muted">Something else</span>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" class="img-responsive" alt="Generic placeholder thumbnail" height="200" width="200">
    <h4>Label</h4>
    <span class="text-muted">Something else</span>
  </div>
  <div class="col-xs-6 col-sm-3 placeholder">
    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" class="img-responsive" alt="Generic placeholder thumbnail" height="200" width="200">
    <h4>Label</h4>
    <span class="text-muted">Something else</span>
  </div>
</div>

<table class="table table-hover">
    <tr>
      <th>Time-stamp</th>
      <th>Event</th>
    </tr>
    @foreach ($events as $event)
      <tr>
        <td>{{ $event->recorded_on }}</td>
        <td>{{ $event->type }}</td>
      </tr>
    @endforeach
</table>
@endsection