<p>
    The membership fee at our association is €5,- per year.
    Additionaly, there may be extra costs for you if you want to buy food and drinks in our membersroom or if you'd like to attend payed events.
</p>

<div class="row">
    <div class="col col-md-8">

        <x-forms.text
            name="iban"
            label="International Bank Account Number (IBAN)"
            placeholder="NL91 ABNA 0417 1643 00"
        >
            <x-slot name="help">
                <p class="form-text text-muted">
                    We will use your IBAN to automatically withdraw your expenses.
                    Once your registration has been completed, a board member will ask you to sign a form of consent to allow us to withdraw money from your account.
                </p>
            </x-slot>
        </x-forms.text>


        <x-forms.checkbox name="deduct_additional_costs">
            <x-slot name="label">
                Allow deducting additional costs for buying food & drinks and attending activities
            </x-slot>
        </x-forms.checkbox>
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
