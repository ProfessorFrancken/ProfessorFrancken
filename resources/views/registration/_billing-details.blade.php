<style>
 .grow {
     transition: all .2s ease-in-out;
     transform: scale(1.1);
     margin: 2em 0;
     box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
 }

 .custom-control {
     font-size: 150%;
 }
</style>

<p>
    The membership fee at our association is €5,- per year. Additionaly there may be extra costs for you if you want to buy food and drinks in our membersroom or if you'd like to attend payed events.
</p>

<div class="row no-gutters rounded grow">
    <div class="col-md-4 text-center">
        <label class="bg-primary h-100 rounded p-4 d-flex flex-column justify-content-between align-items-center">
                <h4 class="text-white">Membership &<br>Additional costs</h4>

                <p class="text-white">
                    Your membership fee and additional costs will be withdrawn from your bank
                </p>


                <span class="custom-control custom-checkbox">

                    {!! Form::radio('payment', 'all-in', true, ['class' => 'custom-control-input']) !!}
                    <span class="custom-control-indicator"></span>
                </span>

        </label>
    </div>
    <div class="col-md-4 text-center">

        <label class="bg-secondary h-100 rounded p-4 d-flex flex-column justify-content-between align-items-center">
                <h4>Membership</h4>

                <p class="text-primary">
                    Only your membership subscription will be withdrawn from you bank account
                </p>

                <span class="custom-control custom-checkbox">
                {!! Form::radio('payment', 'membership', false, ['class' => 'custom-control-input']) !!}
                    <span class="custom-control-indicator"></span>
                </span>
        </label>
    </div>
    <div class="col-md-4 text-center">
        <label class="bg-faded h-100 rounded p-4 d-flex flex-column justify-content-between align-items-center">
                <h4>Pay in cash</h4>

                <p>
                    You will have to pay for your subscription and additoinal costs either in cash or by a manual bank transfer
                </p>

                <span class="custom-control custom-checkbox">
                {!! Form::radio('payment', 'membership', false, ['class' => 'custom-control-input']) !!}
                    <span class="custom-control-indicator"></span>
                </span>
        </label>
    </div>
</div>

<div class="form-group row mt-5">
    <div class="col col-md-8">
        <label for="iban" class="form-control-label">
            International Bank Account Number (IBAN)
        </label>
        {!! Form::text('iban', null, ['placeholder' => 'NL91 ABNA 0417 1643 00', 'class' => 'form-control']) !!}

        <p class="form-text text-muted">
            We will use your IBAN number to automatically withdraw your expenses. Once your registration has been completed a board member will ask you to sign a form of consent to allow us to withdraw money from your account.
        </p>
    </div>

    <div class="col-md-4">
        <p class="form-text text-muted">
            <strong>Don't have an IBAN number?</strong>
        </p>

        <p class="form-text text-muted">
            You can always submit your (new) IBAN number later in the year. However you won't be able to buy food and drinks from our streepsysteem.
        </p>
    </div>
</div>
