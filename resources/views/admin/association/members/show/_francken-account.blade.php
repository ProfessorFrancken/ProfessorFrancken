<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h4>
                Francken Account
            </h4>
            <div>
                @if ($account !== null)
                    <i class="far fa-check-circle text-muted"></i>
                @else
                    <i class="far fa-times-circle text-danger"></i>
                @endif
            </div>
        </div>
        @if ($account !== null)
            <p class="mb-0">
                {{ $member->fullname }} has an account with {{ $account->roles_count }} roles and {{ $account->permissions_count }} permissions.
            </p>
        @else
            <div class="my-3 bg-light py-3 px-2">
                <p class="mb-0 text-center" style="font-size: 0.8rem">
                    {{ $member->fullname }} does not have a Francken account.
                </p>
            </div>
        @endif
    </div>
</div>
