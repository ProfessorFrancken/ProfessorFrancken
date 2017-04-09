@extends('admin.layout')

@section('content')
  <h1 class="page-header">Activities</h1>

  <div class="row">
    <div class="col-sm-4">
      @include("admin.activity._create")
    </div>

    <div class="col-sm-8">
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
          <td>
            <button class="btn btn-default btn-xs">
              <i class="fa fa-edit"></i>
              edit
            </button>
          </td>
        </tr>
      </table>
    </div>
  </div>
@endsection
