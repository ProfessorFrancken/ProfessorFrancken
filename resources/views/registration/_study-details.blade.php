<h3>Study Details</h3>
<div class="row">
  <div class="col-sm-8">
    <div class="form-group row">
      <div class="col-sm-4">
        <label for="study">Study</label>
        {!! Form::text('study', null, ['placeholder' => 'Msc Applied Mathematics', 'class' => 'form-control']) !!}
      </div>
      <div class="col-sm-4">
        <label for="student-number">Student number</label>
        {!! Form::text('student-number', null, ['placeholder' => 's2218356', 'class' => 'form-control']) !!}
      </div>
      <div class="col-sm-4">
        <label for="starting-date-study">Starting date study</label>
        {!! Form::input('month', 'starting-date-study', null, ['placeholder' => 'yyyy-mm', 'class' => 'form-control']) !!}
      </div>
    </div>
  </div>
</div>
