<h3>
    Committee members
</h3>

<div class="row">
    @foreach ($members as $member)
        <div class="col-12 col-sm-6 my-3">
            <div class="media">
                <img
                    class="committee-member__photo"
                    src="https://api.adorable.io/avatars/75/{{ $member->member_id }}.png"
                    alt="Photo of {{ $member->member->full_name }}"
                >
                <div class="align-self-center">
                    <h5>
                        {{ $member->member->full_name }}
                    </h5>
                </div>
            </div>
        </div>
    @endforeach
</div>
<hr/>
