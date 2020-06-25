<div class="d-flex justify-content-between">
    <h5 class="h6 font-weight-bold">
        @if ($partner->footer && $partner->footer->is_enabled)
            <i class="far fa-check-square"></i>
            Footer <small>({{ $partner->footer->referral_url }})</small>
        @else
            <i class="far fa-square"></i>
            Footer
        @endif
    </h5>
    <div class="mb-0">
        @if ($partner->footer === null)
            <a
                href="{{ action([\Francken\Extern\Http\AdminFootersController::class, 'create'], ['partner' => $partner]) }}"
                class="btn btn-text btn-sm"
            >
                <i class="fas fa-plus"></i>
                Enable footer
            </a>
        @else
            <a
                href="{{ action([\Francken\Extern\Http\AdminFootersController::class, 'edit'], ['partner' => $partner])}}"
                class="btn btn-text btn-sm px-0"
            >
                <i class="fas fa-edit"></i>
                Edit footer
            </a>
        @endif
    </div>
</div>
@if ($partner->footer && $partner->footer->is_enabled)
    <a href={{ $partner->footer->referral_url }} class="my-3">
        <img
            class="rounded mr-3 my-3"
            src="{{ $partner->footer->logo }}"
            alt="Logo of {{ $partner->name }}"
        >
    </a>
@endif
@if ($partner->footer !== null)
    <p class="mt-3 mb-0 text-muted text-right">
        Last changed {{ $partner->footer->updated_at->diffForHumans() }}
    </p>
@endif
