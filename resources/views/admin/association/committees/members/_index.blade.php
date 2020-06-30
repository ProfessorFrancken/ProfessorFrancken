<h4 class="font-weight-bold">
    <i class="fas fa-users"></i>
    Members
</h4>

<p>
    Edit a member to change their function, install date or decharge date.
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

<form class="form mb-4">
    <div class="row">
        <div class="form-group col">
            <label>Member</label>
            <input type='text' class="form-control" />
        </div>
        <div class="form-group col">
            <label>Function</label>
            <input type='text' class="form-control" />
        </div>
        <div class="form-group col">
            <label>Install date</label>
            <input type='date' class="form-control" />
        </div>
    </div>
    <button class="btn btn-text text-primary">
        <i class="fas fa-plus"></i>
        Install committee member
    </button>
</form>
