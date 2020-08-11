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
        <div class="form-group">
            <label for="name">Board name</label>
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Hè Watt?', 'id' => 'name']) !!}
        </div>
        <div class="form-group">
            <label for="installed_at">Installed at</label>
            {!!
               Form::date(
                   'installed_at',
                   optional($board->installed_at)->format('Y-m-d'),
                   ['class' => 'form-control', 'id' => 'installed_at']
               );
            !!}
        </div>
        @if ($board->exists)
            <div class="form-group">
            <label for="demissioned_at">Demissioned at</label>
            {!!
               Form::date(
                   'demissioned_at',
                   optional($board->demissioned_at)->format('Y-m-d'),
                   ['class' => 'form-control', 'id' => 'demissioned_at']
               );
            !!}
        </div>
        @endif

    </div>
    <div class="col">
        <div class="d-flex flex-column justify-content-end h-100">
        <x-forms.image-upload
            name="photo"
            label="Board logo"
            output-image-id="board-photo"
        />

        <div class="form-group">
            <label for="photo-position">Photo position</label>
            {!!
               Form::select('photo_position', $photo_positions, null, ['class' => 'form-control', 'id' => 'photo-position']);
            !!}
        </div>
        @if ($board->exists)
        <div class="form-group">
            <label for="decharged_at">Decharged at</label>
            {!!
               Form::date(
                   'decharged_at',
                   optional($board->decharged_at)->format('Y-m-d'),
                   ['class' => 'form-control', 'id' => 'decharged_at']
               )
            !!}
        </div>
        @endif
        </div>
    </div>
</div>

<h5 class="mt-4 mb-3">Board members</h5>
<ul class="list-unstyled row">
    {{--
       We always want to give the user the option to add 5 (optional )board members
    --}}
    @foreach (range(0, 4) as $member_idx)
        @include('admin.association.boards._member_form', [
            'member_idx' => $member_idx,
            'member' => $board->members[$member_idx] ?? new \Francken\Association\Boards\BoardMember,
            'board' => $board,
        ])
    @endforeach
</ul>
