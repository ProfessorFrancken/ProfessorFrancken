<div class="d-flex justify-content-between">
    <h5 class="h6 font-weight-bold">
        @if ($partner->fccFooter && $partner->fccFooter->is_enabled)
            <i class="far fa-check-square"></i>
            Francken Consumption Counter Footer
        @else
            <i class="far fa-square"></i>
            Francken Consumption Counter Footer
        @endif
    </h5>
    <div class="mb-0">
        @if ($partner->fccFooter === null)
            <a
                href="{{ action([\Francken\Extern\Http\AdminFccFootersController::class, 'create'], ['partner' => $partner]) }}"
                class="btn btn-text btn-sm"
            >
                <i class="fas fa-plus"></i>
                Enable fcc footer
            </a>
        @else
            <a
                href="{{ action([\Francken\Extern\Http\AdminFccFootersController::class, 'edit'], ['partner' => $partner])}}"
                class="btn btn-text btn-sm px-0"
            >
                <i class="fas fa-edit"></i>
                Edit fcc footer
            </a>
        @endif
    </div>
</div>
@if ($partner->fccFooter && $partner->fccFooter->is_enabled)
    <img
        class="rounded m-3"
        src="{{ $partner->fccFooter->logo }}"
        alt="Logo of {{ $partner->name }}"
        style="max-height: 150px; max-width: 300px;"
    >
@endif
@if ($partner->fccFooter !== null)
    <p class="mt-3 mb-0 text-muted text-right">
        Last changed {{ $partner->fccFooter->updated_at->diffForHumans() }}
    </p>
@endif
