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
        <div class="form-group">
            <label for="add-board-photo" class="btn btn-block btn-sm btn-primary mb-0">
                <i class="fas fa-upload"></i>
                Board photo
            </label>
            {!! Form::file('photo', ['class' => 'sr-only form-control-file', 'id' => 'add-board-photo']) !!}
        </div>

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

@push('scripts')
<script>
 (function() {
     var loadFile = function(event) {
         console.log(event);
         var reader = new FileReader();
         reader.onload = function(){
             var output = document.getElementById('board-photo');
             output.src = reader.result;
             console.log(output);
         };
         reader.readAsDataURL(event.target.files[0]);
     };

     var addBoardPhoto = document.getElementById('add-board-photo');
     addBoardPhoto.addEventListener('change', loadFile);

     console.log()
     var boardPhoto = document.getElementById('board-photo');
     boardPhoto.addEventListener('click', function() {
         addBoardPhoto.click();
     });
 })()
</script>
@endpush
