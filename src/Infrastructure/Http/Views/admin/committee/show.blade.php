@extends('layouts.dashboard')



@section('content')
  <h1 class="page-header">{{ $committee->name }}</h1>


  <h3>General info</h3>
  <form action="{{ url('admin/committee', $committee->id) }}" method="POST" class="form-horizontal">
    {!! csrf_field() !!}
    {{ method_field('PUT') }}

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

    <?php $i = 1 ?>
    @foreach(json_decode($committee->members) as $member)
    <tr>
      <td>{{ $i++ }}</td>
      <td>{{ $member->first_name }}</td>
      <td>{{ $member->last_name }}</td>
      <td>
        <form action="{{ url('admin/committee/' . $committee->id . '/member/' . $member->uuid) }}" method="POST">
          {!! csrf_field() !!}
          {{ method_field('DELETE') }}

          <button class="btn btn-primary" name="remove-member"><span class="glyphicon glyphicon-trash"></span></button>
        </form>
      </td>
    </tr>
    @endforeach
  </table>

  <h4>Add members</h4>
  <table class="table table-hover">
    <tr>
      <form id="searchForm" action="{{ url('admin/committee/search-member') }}" method="POST" target="searchResults">
        {!! csrf_field() !!}
        <th><input type="text" class="form-control" name="first_name" placeholder="first name"></th>
        <th><input type="text" class="form-control" name="last_name" placeholder="last name"></th>
        <th><button type="submit" class="btn btn-default">Search</button></th>
      </form>
    </tr>

    @if( session('searchResults') )
      @foreach( session('searchResults') as $result)
      <tr>
        <td>{{ $result->first_name }}</td>
        <td>{{ $result->last_name }}</td>
        <td>
          <form action="{{ url('admin/committee/' . $committee->id . '/member/' . $result->uuid) }}" method="POST">
            {!! csrf_field() !!}

            <button class="btn btn-default" name="add-member"><span class="glyphicon glyphicon-plus"></span></button>
          </form>
        </td>
      </tr>
      @endforeach
    @endif
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
