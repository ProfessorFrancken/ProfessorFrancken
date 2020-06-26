<div class="d-flex justify-content-between">
    <h5 class="h6 font-weight-bold">
        @if ($partner->companyProfile && $partner->companyProfile->is_enabled)
            <i class="far fa-check-square"></i>
        @else
            <i class="far fa-square"></i>
        @endif
        Company profile
    </h5>

    <div class="mb-0">
        @if ($partner->companyProfile !== null)
            <a
                href="{{ action([\Francken\Extern\Http\AdminCompanyProfilesController::class, 'edit'], ['partner' => $partner])}}"
                class="btn btn-text btn-sm px-0"
            >
                <i class="fas fa-edit"></i>
                Edit company profile
            </a>
        @else
            <a
                href="{{ action([\Francken\Extern\Http\AdminCompanyProfilesController::class, 'create'], ['partner' => $partner]) }}"
                class="btn btn-text btn-sm px-0"
            >
                <i class="fas fa-plus"></i>
                Enable company profile
            </a>
        @endif
    </div>
</div>
@if ($partner->companyProfile === null)
    <p>
        This partner has no company profile
    </p>
@else
    <div class='p-3 bg-light mt-3'>
        <h5 class="h6">
            {{ $partner->companyProfile->display_name }}
        </h5>
        <div style="max-height: 330px; overflow: auto;">
            {!!  $partner->companyProfile->compiled_content !!}
        </div>
    </div>
    <p class="mt-3 mb-0 text-muted text-right">
        Last changed {{ $partner->companyProfile->updated_at->diffForHumans() }}
    </p>
@endif
