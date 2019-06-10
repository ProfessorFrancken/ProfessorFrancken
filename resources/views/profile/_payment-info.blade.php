@component('profile._profile', ['icon' => 'fas fa-money-check-alt'])
    <h6 class="text-body font-weight-light text-monospace">
        {{ $paymentInfo->iban()  }}
    </h6>

    <p>
        You've authorized T.F.V. 'Professor Francken' to withdraw money from the bank account listed above, due to:
    </p>
    <ul class="list-unstyled">
        @if (! $paymentInfo->freeMembership())
            <li>
                <i class="fas fa-check fa-xs text-primary"></i> Membership (€5,- per year)
            </li>
        @endif
        @if ($paymentInfo->paymentMethod() === 'Afschrijven')
            <li>
                <i class="fas fa-check fa-xs text-primary"></i> Drinking and eating expenses and any potential costs incurred at other activities of the association.
            </li>
        @endif
    </ul>
@endcomponent
