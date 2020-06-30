<div class="card">
    <div class="card-body">
        <h4 class="font-weight-bold">
            <i class="fas fa-users"></i>
            Members
        </h4>

        <p>

        </p>

        <ul class="list-unstyled mb-4">
            @foreach ($committee->members as $member)
                <li class="p-2 my-2 bg-light d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column justify-content-between" >
                        <span class="font-weight-bold">
                            {{ $member->member->full_name }}
                        </span>

                        <small class="text-muted">
                            {{ $member->function }}
                        </small>
                    </div>
                    <div class="ml-auto d-flex align-items-center">
                        @if ($member->decharged_at !== null)
                            <small class="text-muted">
                                decharged {{ $member->decharged_at->diffForHumans() }}
                            </small>
                        @endif
                        <a
                            class="btn btn-text text-primary btn-sm"
                            href=""
                        >
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
        <h5 class="font-weight-bold">
            Install committee member
        </h5>
        <h5 class="font-weight-bold">
            Suggested committeem members
        </h5>
    </div>
</div>
