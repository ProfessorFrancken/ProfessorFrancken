<p>
    The membership fee at our association is €5,- per year.
    Additionaly, there may be extra costs for you if you want to buy food and drinks in our membersroom or if you'd like to attend payed events.
</p>

<div class="row no-gutters rounded grow d-none">
    <div class="col-md-4 text-center">
        <label class="bg-primary h-100 rounded p-4 d-flex flex-column justify-content-between align-items-center" for='pay-membership'>
            <h4 class="text-white">Membership &<br>Additional costs</h4>

            <p class="text-white">
                Your membership fee and additional costs will be withdrawn from your bank
            </p>

            <div class="custom-control custom-radio">
                <span class="custom-control-label "></span>
                {!!
                   Form::radio(
                       'payment',
                       'all-in',
                       true,
                       [
                           'class' => 'custom-control-input',
                           'id' => 'pay-membership',
                       ]
                   )
                !!}
            </div>
        </label>
    </div>

    <div class="col-md-4 text-center">
        <label class="custom-control-label bg-secondary h-100 rounded p-4 d-flex flex-column justify-content-between align-items-center" for='pay-membership-only'>
            <h4>Membership</h4>

            <p class="text-primary">
                Only your membership subscription will be withdrawn from you bank account
            </p>

            <div class="custom-control custom-radio">
                {!!
                   Form::radio(
                       'payment',
                       'membership-only',
                       false,
                       [
                           'class' => 'custom-control-input',

                           'id' => 'pay-membership-only',
                       ]
                   )
                !!}
            </div>
        </label>
    </div>

    <div class="col-md-4 text-center">
        <label class="custom-control-label bg-faded h-100 rounded p-4 d-flex flex-column justify-content-between align-items-center"
               for="pay-in-cash"
        >
            <h4>Pay in cash</h4>

            <p>
                You will have to pay for your subscription and additoinal costs either in cash or by a manual bank transfer
            </p>

            <div class="custom-control custom-radio">
                {!!
                   Form::radio(
                       'payment',
                       'pay-in-cash',
                       false,
                       [
                           'class' => 'custom-control-input',
                           'id' => 'pay-in-cash',
                       ]
                   )
                !!}
                <label >Pay in cash</label>
            </div>
        </label>
    </div>
</div>

<div class="form-group row">
    <div class="col col-md-8">
        <label for="iban" class="form-control-label">
            International Bank Account Number (IBAN)
        </label>
        {!!
           Form::text(
               'iban',
               null,
               [
                   'placeholder' => 'NL91 ABNA 0417 1643 00',
                   'class' => 'form-control',
               ]
           )
        !!}

        <p class="form-text text-muted">
            We will use your IBAN to automatically withdraw your expenses.
            Once your registration has been completed, a board member will ask you to sign a form of consent to allow us to withdraw money from your account.
        </p>

        <div class="form-check">
            {!!
               Form::checkbox(
                   'deduct_additional_costs',
                   true,
                   false,
                   [
                       'id' => 'deduct_additional_costs',
                       'class' => 'form-check-input'
                   ]
               )
            !!}
            <label class="form-check-label" for="deduct_additional_costs">
                Allow deducting additional costs for buying food & drinks and attending activities
            </label>
        </div>
    </div>

    <div class="col-md-4">
        <p class="form-text text-muted">
            <strong>Don't have an IBAN?</strong>
        </p>

        <p class="form-text text-muted">
            You can always submit your (new) IBAN later in the year. However you won't be able to buy food and drinks from our streepsysteem.
        </p>
    </div>
</div>
