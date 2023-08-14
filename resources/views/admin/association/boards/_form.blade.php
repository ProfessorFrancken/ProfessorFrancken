<div class="row">
    <div class="col-12">
        <img
            id="board-photo"
            alt="Photo of the board"
            src="{{ optional($board)->photo }}"
            class="mb-3 img-fluid w-100 rounded"
            style="object-fit: cover"
        />
    </div>

    <div class="col">
        <x-forms.text name="name" label="Board name" placeholder="Hè Watt?" />
        <x-forms.date name="installed_at" label="Installed at" :value="optional($board->installed_at)->format('Y-m-d')"/>
        @if ($board->exists)
            <x-forms.date name="demissioned_at" label="Demissioned at" :value="optional($board->demissioned_at)->format('Y-m-d')"/>
        @endif

    </div>
    <div class="col">
        <div class="d-flex flex-column justify-content-end h-100">
        <x-forms.image-upload
            name="photo"
            label="Board logo"
            output-image-id="board-photo"
        />

        <x-forms.select name="photo_position" label="Photo position" :options="$photo_positions" />
        @if ($board->exists)
            <x-forms.date name="decharged_at" label="Decharged at" :value="optional($board->decharged_at)->format('Y-m-d')"/>
        @endif
        </div>
    </div>
</div>

<h5 class="mt-4 mb-3">Board members</h5>
<ul class="list-unstyled row">
    {{--
       We always want to give the user the option to add 5 (optional )board members
    --}}
    @foreach (range(0, 5) as $member_idx)
        @include('admin.association.boards._member_form', [
            'member_idx' => $member_idx,
            'member' => $board->members[$member_idx] ?? new \Francken\Association\Boards\BoardMember,
            'board' => $board,
        ])
    @endforeach
</ul>
