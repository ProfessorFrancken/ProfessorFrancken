<h1>Committee Controller</h1>

<form action="{{ url('admin/committee') }}" method="POST" class="form-horizontal">
  {!! csrf_field() !!}

  <div class="form-group">
    <label class="col-sm-2 control-label">Committee name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="inputName">
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-2 control-label">Committee goal</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="inputGoal">
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Create committee</button>
    </div>
  </div>

</form>