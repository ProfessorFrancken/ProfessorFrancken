<h3>
    Committee members
</h3>

@foreach($committee['years'] as $members)
    <div class="row">
        @foreach ($members as $member)
            <div class="col-12 col-sm-6 my-3">
                <div class="media">
                    <img
                        class="d-flex mr-3"
                        src="https://api.adorable.io/avatars/75/{{ $member['id'] }}.png"
                        alt="Generic placeholder image"
                        style="width: 75px; height: 75px; object-fit: cover; border-radius: 50%;"
                    >
                    <div class="media-body align-self-center">
                        <h5 class="mt-0">
                            {{ $member['firstname'] }}
                            {{ $member['surname'] }}
                        </h5>
                        {{--
                        <p class="text-muted">
                        Role: editor
                        </p>
                        --}}

                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <hr/>
@endforeach
