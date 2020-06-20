<h5 class="mt-4 mx-2">
    <i class="fas fa-money-check-alt" aria-hidden="true"></i>
    Billing details
</h5>
<div class="bg-light p-3">
    @if ($registration->paymentDetails->iban() !== null)
        <p>
            <strong>IBAN</strong>
            {{ $registration->paymentDetails->iban() }}
        </p>
        @if ($registration->paymentDetails->bic() !== null)
            <p>
                <strong>BIC</strong>
                {{ $registration->paymentDetails->bic() }}
            </p>
        @endif

        <p class="mb-1">
            @if ($registration->paymentDetails->deductAdditionalCosts())
                <i class="fas fa-check font-weight-bold"></i> Costs from activities and buying food & drinks will be deducted from your bank account
            @else
                <i class="fas fa-times font-weight-bold"></i> Costs from activities and buying food & drinks will have to be paid manually
            @endif
        </p>
    @else
        <p class="mb-1">
            You did not provide an IBAN when registering your membership.
            Please let us know your IBAN
        </p>
    @endif
</div>
