<h4 class="font-weight-bold">
    <i class="fas fa-users"></i>
    Members
</h4>

<p>
    Edit a member to change their function, install date or decharge date.
</p>

<ul class="list-unstyled mb-5">
    @foreach ($committee->members as $committeeMember)
        <li class="p-2 my-2 bg-light d-flex justify-content-between align-items-center">
            <div class="d-flex flex-column justify-content-between" >
                <span class="font-weight-bold">
                    {{ $committeeMember->member->full_name }}
                </span>

                <small class="text-muted">
                    {{ $committeeMember->function }}
                </small>
            </div>
            <div class="ml-auto d-flex align-items-center">
                @if ($committeeMember->decharged_at !== null)
                    <small class="text-muted">
                        decharged {{ $committeeMember->decharged_at->diffForHumans() }}
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

@include('admin.association.committees.members._create', ['committee' => $committee, 'members' => $members])
