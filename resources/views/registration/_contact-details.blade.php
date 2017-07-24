<p>
    Each year we publish three issues of our popular science magazine the <a href="/association/francken-vrij">Francken Vrij</a>.
    Once you've been registered we will sent you a printed copy whenever a new issue of our magazine is released.
    You will also receive our biweekly newsletter on your email informing you of events at our association and university.
</p>
<div class="row">
  <div class="col-sm-12 col-md-8">

    <div class="form-group row">
      <div class="col-sm-6">
        <label>Email</label>
        {!! Form::email('email', null, ['placeholder' => 'email@example.com', 'class' => 'form-control', 'required']) !!}
      </div>

      <div class="col-sm-6">
        <label>City</label>
        {!! Form::text('city', null, ['placeholder' => 'Groningen', 'class' => 'form-control', 'required']) !!}
      </div>

    </div>


    <div class="form-group row">
      <div class="col-sm-6">
        <label for="Address">Address</label>
        {!! Form::text('address', null, ['placeholder' => 'Neijenborgh 9', 'class' => 'form-control', 'required']) !!}
      </div>

      <div class="col-sm-6">
        <label for="zip-code">ZIP code</label>
        {!! Form::text('zip-code', null, ['placeholder' => '9742 AG', 'class' => 'form-control', 'required']) !!}
      </div>
    </div>

  </div>
</div>
