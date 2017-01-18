<div class="form-group">
  {!! Form::label('isbn', 'ISBN-10', null, ['class' => 'form-control']) !!}
  {!! Form::text('isbn', null, ['placeholder' => '123456789X', 'class' => 'form-control']) !!}
</div>

<div class="form-group">
  {!! Form::label('price', 'Price', null, ['class' => 'form-control']) !!}
  <div class="input-group">
    <span class="input-group-addon">€</span>
    {!! Form::number('price', null, ['placeholder' => '15,00', 'class' => 'form-control']) !!}
  </div>
</div>

{!! Form::submit('Offer!', ['class' => 'btn btn-primary']) !!}