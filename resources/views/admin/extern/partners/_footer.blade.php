<li class="p-3 bg-light my-3">
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
        @if ($partner->footer && $partner->footer->is_enabled)
            <a href={{ $partner->footer->referral_url }}>
                <img
                    class="rounded mr-3"
                    src="{{ $partner->footer->logo }}"
                    alt="Logo of {{ $partner->name }}"
                >
            </a>
        @endif
    </div>
    @if ($partner->footer === null)
        <a
            href="{{ action([\Francken\Extern\Http\AdminFootersController::class, 'create'], ['partner' => $partner]) }}"
            class="btn btn-text btn-sm"
        >
            <i class="fas fa-check"></i>
            Enable footer
        </a>
    @else
        <div class="d-flex justify-content-between align-items-end">
            <p class="mb-0 mt-3">
                <a
                    href="{{ action([\Francken\Extern\Http\AdminFootersController::class, 'edit'], ['partner' => $partner])}}"
                    class="btn btn-text btn-sm px-0"
                >
                    <i class="fas fa-edit"></i>
                    Edit footer
                </a>
            </p>
            <p class="mb-0 text-muted">
                Last changed {{ $partner->footer->updated_at->diffForHumans() }}
            </p>
        </div>
    @endif
</li>
