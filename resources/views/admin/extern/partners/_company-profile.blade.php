<li class="p-3 bg-light my-3">
    <h5 class="h6 font-weight-bold">
        @if ($partner->companyProfile && $partner->companyProfile->is_enabled)
            <i class="far fa-check-square"></i>
        @else
            <i class="far fa-square"></i>
        @endif
        Company profile
    </h5>
    @if ($partner->companyProfile === null)
        <p>
            This partner has no company profile
        </p>

        <a
            href="{{ action([\Francken\Extern\Http\AdminCompanyProfilesController::class, 'create'], ['partner' => $partner]) }}"
            class="btn btn-text btn-sm"
        >
            <i class="fas fa-check"></i>
            Enable company profile
        </a>
    @else
        <div class='p-3 bg-white mt-3'>
            <h5 class="h6">Content:</h5>
            <div style="max-height: 330px; overflow: auto;">
                {!!  $partner->companyProfile->compiled_content !!}
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-end">
            <p class="mb-0 mt-3">
                <a
                    href="{{ action([\Francken\Extern\Http\AdminCompanyProfilesController::class, 'edit'], ['partner' => $partner])}}"
                    class="btn btn-text btn-sm px-0"
                >
                    <i class="fas fa-edit"></i>
                    Edit company profile
                </a>
            </p>
            <p class="mb-0 text-muted">
                Last changed {{ $partner->companyProfile->updated_at->diffForHumans() }}
            </p>
        </div>
    @endif
</li>
