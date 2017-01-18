@extends('admin.layout')

@section('content')
  <h1 class="page-header">{{ $committee->name() }}</h1>

  <h3>General info</h3>

  {!! Form::open(['url' => url('admin/committee', (string)$committee->committeeId()), 'method' => 'PUT']) !!}

    <div class="form-group">
      {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
      <a class="edit-btn btn btn-info"><span class="glyphicon glyphicon-pencil"></span></a>
      {!! Form::text('name', $committee->name(), ['class' => 'edit-input form-control', 'readonly']) !!}
    </div>

    <div class="form-group">
      {!! Form::label('email', 'Email (optional):', ['class' => 'control-label']) !!}
      <a class="edit-btn btn btn-info"><span class="glyphicon glyphicon-pencil"></span></a>
      {!! Form::text('email', (string)$committee->email(), ['class' => 'edit-input form-control', 'readonly']) !!}
    </div>

    <div class="form-group">
      {!! Form::label('summary', 'Summary:', ['class' => 'control-label']) !!}
      <a class="edit-btn btn btn-info"><span class="glyphicon glyphicon-pencil"></span></a>
      {!! Form::textarea('summary', $committee->summary(), ['class' => 'edit-input form-control', 'rows' => 2, 'readonly']) !!}
    </div>

    <div class="form-group">
      {!! Form::label('page', 'Commitee page (optional):', ['class' => 'control-label']) !!}
      <a class="edit-btn btn btn-info"><span class="glyphicon glyphicon-pencil"></span></a>
      {!! Form::textarea('page', $committee->markDown(), ['class' => 'edit-input form-control', 'readonly']) !!}
    </div>

    {!! Form::submit('Edit!', ['class' => 'btn btn-success']) !!}

  {!! Form::close() !!}

  <h3>Members</h3>
  <table class="table table-hover">
    <tr>
      <th>#</th>
      <th>Last name</th>
      <th>First name</th>
      <th></th>
    </tr>

    <?php $i = 1 ?>
    @foreach($committee->members() as $member)
    <tr>
      <td>{{ $i++ }}</td>
      <td>{{ $member['first_name'] }}</td>
      <td>{{ $member['last_name'] }}</td>
      <td>
        <form action="{{ url('admin/committee/' . (string)$committee->committeeId() . '/member/' . $member['id']) }}" method="POST">
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
          <form action="{{ url('admin/committee/' . (string)$committee->committeeId() . '/member/' . $result->id) }}" method="POST">
            {!! csrf_field() !!}

            <button class="btn btn-default" name="add-member"><span class="glyphicon glyphicon-plus"></span></button>
          </form>
        </td>
      </tr>
      @endforeach
    @endif
  </table>

@endsection

@section('script')
  <script type="text/javascript">
    $(function(){
      $(".edit-btn").click(function(){
        $(this).next(".edit-input").removeAttr("readonly");
      })
    });

  </script>
@endsection
