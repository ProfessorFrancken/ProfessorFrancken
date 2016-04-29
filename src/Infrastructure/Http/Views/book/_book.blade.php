
<div class="form-group">
  {!! Form::label('ISBN', null, ['class' => 'form-control']) !!}
  {!! Form::text('ISBN', null, ['placeholder' => '123456789X', 'class' => 'form-control']) !!}
</div>

<div class="form-group">
  {!! Form::label('price', null, ['class' => 'form-control']) !!}
  <div class="input-group">
    <span class="input-group-addon">€</span>
    {!! Form::text('price', null, ['placeholder' => '15,00', 'class' => 'form-control']) !!}
  </div>
</div>