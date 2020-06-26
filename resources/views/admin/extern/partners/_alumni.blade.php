<div class="card mt-4">
    <div class="card-body">
        <h4 class="font-weight-bold">
            <i class="fas fa-graduation-cap"></i>
            Alumni
        </h4>
        <ul class='list-unstyled'>
            @forelse ($partner->alumni as $alumnus)
                <li class="d-flex flex-column my-3 {{ $loop->last ? '' : 'border-bottom  py-3' }}">
                    <div class="d-flex justify-content-start">
                        <div>
                            <h6>
                                <i class="fas fa-user fa-fw text-muted"></i>
                                {{ $alumnus->fullname }}
                            </h6>
                            <ul class="list-unstyled">
                                <li>
                                    {{ $alumnus->position }}
                                </li>
                                <li>
                                    {{ $alumnus->started_position_at->format("Y-m-d") }}
                                    @if ($alumnus->stopped_position_at)
                                    - {{ $alumnus->stopped_position_at->format("Y-m-d") }}
                                    @endif
                                </li>
                            </ul>
                        </div>
                        <div class="ml-auto">
                            <a
                                href="{{ action(
                                         [\Francken\Extern\Http\AdminPartnerAlumniController::class, 'edit'],
                                         ['partner' => $partner, 'alumnus' => $alumnus]
                                         ) }}"
                                class="btn btn-text btn-sm"
                            >
                                <i class="fas fa-edit"></i>
                                Edit alumnus
                            </a>
                        </div>
                    </p>
                </li>
            @empty
                <li class="d-flex flex-column my-3">
                    Keep track of the alumni working for this partner.
                </li>
            @endforelse
        </ul>
    </div>

    <div class="card-footer">
        <a
            href="{{ action([\Francken\Extern\Http\AdminPartnerAlumniController::class, 'create'], ['partner' => $partner]) }}"
            class="btn btn-text btn-sm"
        >
            <i class="fas fa-plus"></i>
            Add alumnus
        </a>
    </div>
</div>
