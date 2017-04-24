<h3>
    Committee members
</h3>

<div class="row">
    @foreach ($members as $member)
        <div class="col-12 col-sm-6 my-3">
            <div class="media">
                <img
                    class="committee-member__photo"
                    src="https://api.adorable.io/avatars/75/{{ $member->id() }}.png"
                    alt="Photo of {{ $member->fullname() }}"
                >
                <div class="align-self-center">
                    <h5>
                        {{ $member->fullname() }}
                    </h5>
                </div>
            </div>
        </div>
    @endforeach
</div>
<hr/>
