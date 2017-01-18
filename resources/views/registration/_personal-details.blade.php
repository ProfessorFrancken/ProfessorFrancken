<div class="row">
  <div class="col-sm-8">

    <div class="form-group">
      <label for="firstname">Name</label>
      <div class="row">
        <div class="col-sm-6">
          {!! Form::text('firstname', null, ['placeholder' => 'Firstname', 'class' => 'form-control']) !!}
        </div>
        <div class="col-sm-6">
          {!! Form::text('surname', null, ['placeholder' => 'Surname', 'class' => 'form-control']) !!}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
          <label for="mother-tongue">Mother tongue</label>
          {!! Form::text('mother-tongue', null, ['placeholder' => 'Dutch', 'class' => 'form-control']) !!}
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label for="birthdate">Birthdate</label>
          {!! Form::date('birthdate', null, ['placeholder' => 'yyyy-mm-dd', 'class' => 'form-control']) !!}
        </div>
      </div>
    </div>

    <div class="form-group">
      <div class="row">
        <div class="col-sm-6">
          <label for="birthdate">Gender</label>
          <div>
          <label class="radio-inline">
            {!! Form::radio('gender', 'female') !!} Female
          </label>
          <label class="radio-inline">
            {!! Form::radio('gender', 'male') !!} Male
          </label>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="col-sm-4">
    <p>
      <small class="text-muted">
        Your profile picture will be used on the website on on the "streepsyteem".
      </small>
    </p>
    <p>
      <small class="text-muted">
        Once you've submitted your request we will send you an email..
      </small>
    </p>
  </div>
</div>
