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

            <x-forms.text
                name="iban"
                label="International Bank Account Number (IBAN)"
                help="We will use your IBAN to automatically withdraw your expenses."
                :value="$member->payment_details->iban()"
            />

            <x-forms.checkbox
                name="deduct_additional_costs"
                label="Allow deducting additional costs for buying food & drinks and attending activities"
                :value="$member->payment_details->deductAdditionalCosts()"
            />
        </div>

        <div class="card-footer">
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@endsection
