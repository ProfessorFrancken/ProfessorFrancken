<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h4>
                Francken Vrij subscription
            </h4>
            <div>
                @if ($subscription->isActiveAt($today))
                    <i class="far fa-check-circle text-muted"></i>
                @else
                    <i class="far fa-times-circle text-danger"></i>
                @endif
            </div>
        </div>

        <p class="mb-0">
            @if ($subscription->isActiveAt($today))
                <i class="far fa-check-circle text-muted"></i>
                {{ $member->fullname }}'s subcsription to the Francken Vrij ends in {{ $subscription->subscription_ends_at->diffForHumans() }}
            @elseif ($subscription->subscription_ends_at !== null)
                {{ $member->fullname }}'s subcsription to the Francken Vrij ended {{ $subscription->subscription_ends_at->diffForHumans() }}.
            @else
                {{ $member->fullname }} does not have an active subcsription to the Francken Vrij.
            @endif
        </p>
    </div>
</div>
