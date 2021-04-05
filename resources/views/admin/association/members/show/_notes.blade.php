<div class="card mb-3">
    <div class="card-body">
        <h4>Notes</h4>


        @if($member->notes)
            <p class="mb-0 bg-light p-3">
                {{ $member->notes  }}
            </p>
        @else
            <div class="my-3 bg-light py-3 px-2">
                <p class="mb-0 text-center" style="font-size: 0.8rem">
                    No notes found for {{ $member->fullname }}.
                </p>
            </div>
        @endif
    </div>
</div>
