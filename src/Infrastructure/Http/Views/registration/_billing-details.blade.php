<p class="lead">
  I hereby give permission to T.F.V. 'Professor Francken' to withdraw money from the bank account listed below due to:
</p>
<div class="form-group">
  <div class="checkbox disabled">
    <label>
      {!! Form::checkbox('membership', 'membership', true, ['disabled' => 'disabled']) !!}
      Membership (€5,- per year)
    </label>
  </div>
</div>
<div class="form-group">
  <div class="checkbox">
    <label>
      {!! Form::checkbox('food-and-drinks', 'food-and-drinks') !!}
      Drinking and eating expenses and any potential costs incurred at other activities of the association.
      <br>(Check if you want to buy food in the Franckenroom.)
    </label>
  </div>

</div>
<div class="form-group row">
  <label for="iban" class="form-control-label col-sm-1">IBAN</label>
  <div class="col-sm-5">
    {!! Form::text('iban', null, ['placeholder' => 'IBAN', 'class' => 'form-control']) !!}
  </div>
</div>
