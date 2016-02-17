@extends('layouts.dashboard')



@section('content')
  <h1 class="page-header">{{ $committee->name }}</h1>


  <h3>General info</h3>
  <form action="{{ url('admin/committee/edit') }}" method="POST" class="form-horizontal">
    {!! csrf_field() !!}

    <input type="hidden" name="id" value="{{ $committee->uuid }}">

    <div class="form-group">
      <label class="col-sm-3 control-label">Committee name</label>
      <div class="col-sm-9">
        <p class="form-control-static">{{ $committee->name }}<a id="editName" href="#"><span class="glyphicon glyphicon-edit"></span></a></p>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label">Committe goal</label>
      <div class="col-sm-9">
        <p class="form-control-static">{{ $committee->goal }}<a id="editGoal" href="#"><span class="glyphicon glyphicon-edit"></span></a></p>
      </div>
    </div>

    <div class="col-sm-9 col-sm-offset-3">
      <button type="submit" class="btn btn-default disabled" id="editBtn">Edit</button>
    </div>
  </form>

  <h3>Members</h3>
  <table class="table table-hover">
    <tr>
      <th>#</th>
      <th>Last name</th>
      <th>First name</th>
      <th></th>
    </tr>

    {{--example--}}
    <tr>
      <td>1</td>
      <td>Boer</td>
      <td>Mark</td>
      <td><a href="#"><span class="glyphicon glyphicon-trash"></span></a></td>
    </tr>
  </table>

  <h3>Committee web page</h3>
  <textarea class="form-control" row="10"></textarea>

@endsection

@section('script')
  <script type="text/javascript">
    $(function(){
      $("#editName").click(function(){
        $("#editBtn").removeClass("disabled");
        text = $(this).parent().text();
        $(this).parent().parent().append($("<input type='text' class='form-control' name='name' value='" + text + "'>"));
        $(this).parent().remove();
      });
    });

    $(function(){
      $("#editGoal").click(function(){
        $("#editBtn").removeClass("disabled");
        text = $(this).parent().text();
        $(this).parent().parent().append($("<input type='text' class='form-control' name='goal' value='" + text + "'>"));
        $(this).parent().remove();
      });
    });
  </script>
@endsection