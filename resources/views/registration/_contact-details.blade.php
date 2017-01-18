<h3>Contact Details</h3>
<div class="row">
  <div class="col-sm-8">

    <div class="form-group row">
      <div class="col-sm-6">
        <label>Email</label>
        {!! Form::email('email', null, ['placeholder' => 'email@example.com', 'class' => 'form-control']) !!}
      </div>

      <div class="col-sm-6">
        <label for="zip-code">ZIP code</label>
        {!! Form::text('zip-code', null, ['placeholder' => '9742 AG', 'class' => 'form-control']) !!}
      </div>
    </div>


    <div class="form-group row">
      <div class="col-sm-6">
        <label>City</label>
        {!! Form::text('city', null, ['placeholder' => 'Groningen', 'class' => 'form-control']) !!}
      </div>

      <div class="col-sm-6">
        <label for="Address">Address</label>
        {!! Form::text('address', null, ['placeholder' => 'Neijenborgh 9', 'class' => 'form-control']) !!}
      </div>
    </div>

  </div>
</div>
