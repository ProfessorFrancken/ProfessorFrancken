@extends('profile.layout')

@section('content')
    <h4 class="font-weight-bold section-header">
        <i class="fas fa-message"></i>
        Change payment details
    </h4>


    <div class="card my-3">
        {!!
               Form::model(
                   $member, [
                       'url' => action([\Francken\Association\Members\Http\PaymentDetailsController::class, 'update']),
               ])
        !!}
        <div class="card-body">

            @method('PUT')

            <label for="iban" class="form-control-label">
                International Bank Account Number (IBAN)
            </label>
            {!!
                   Form::text(
                       'iban',
                       $member->payment_details->iban(),
                       [
                           'placeholder' => 'NL91 ABNA 0417 1643 00',
                           'class' => 'form-control' . ($errors->has('iban') ? ' is-invalid' : ''),
                       ]
                   )
            !!}
            @error('iban')
            <p class="invalid-feedback">
                {{ $message  }}
            </p>
            @enderror

            <p class="form-text text-muted">
                We will use your IBAN to automatically withdraw your expenses.
            </p>

            <div class="form-check">
                {!!
                       Form::checkbox(
                           'deduct_additional_costs',
                           true,
                           $member->payment_details->deductAdditionalCosts(),
                           [
                               'id' => 'deduct_additional_costs',
                               'class' => 'form-check-input' . ($errors->has('deduct_additional_costs') ? ' is-invalid' : ''),
                               'checked' => $member->payment_details->deductAdditionalCosts()
                           ]
                       )
                !!}
                <label class="form-check-label" for="deduct_additional_costs">
                    Allow deducting additional costs for buying food & drinks and attending activities
                </label>
                @error('deduct_additional_costs')
                <p class="invalid-feedback">
                    {{ $message  }}
                </p>
                @enderror
            </div>
        </div>

        <div class="card-footer">
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@endsection
