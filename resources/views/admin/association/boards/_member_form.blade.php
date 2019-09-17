<li class="col">
    {!!
       Form::hidden(
           "members[{$member_idx}][id]",
           optional($member)->id
       )
    !!}
    <div class="bg-white shadow-sm p-3 rounded">
        <img
            id={{ "members-photo[{$member_idx}]" }}
            alt="Photo of board member"
            src="{{ optional($member)->photo }}"
            class="img-fluid rounded w-100 d-block mb-3 border"
            style="height: 150px; object-fit: cover"
        />

        <div class="form-group">
            <label for='{{ "members[{$member_idx}][photo]" }}'  class="btn btn-block btn-sm btn-primary mb-0">
                <i class="fas fa-upload"></i>
                Board member photo
            </label>
            {!!
               Form::file(
                   "members[{$member_idx}][photo]",
                   [
                   'class' => 'sr-only form-control-file mt-3',
                   'id' => "members[{$member_idx}][photo]"
                   ]
               )
            !!}
        </div>

        <div class="form-group">
            @include('admin.association.boards._member-selection', [
                'name' => "members[{$member_idx}]",
                'id' => optional($member)->member_id,
                'member_name' => optional($member)->name,
            ])
        </div>

        <div class="form-group">
            <label for="members[{$member_idx}][title]">Title</label>
            {!!
               Form::text(
                   "members[{$member_idx}][title]",
                   optional($member)->title,
                   ['class' => 'form-control', 'id' => 'title']
               )
            !!}
        </div>

        @if ($board->exists)
        <div class="form-group">
            <label for="members[{$member_idx}][installed_at]">Install date</label>
            {!!
               Form::date(
                   "members[{$member_idx}][installed_at]",
                   optional($member)->installed_at,
                   ['class' => 'form-control', 'id' => 'installed_at']
               );
            !!}
        </div>
        @if ($member->exists)
            <div class="form-group">
                <label for="members[{$member_idx}][demissioned_at]">Demissioned date</label>
                {!!
                   Form::date(
                       "members[{$member_idx}][demissioned_at]",
                       optional($member)->demissioned_at,
                       ['class' => 'form-control', 'id' => 'demissioned_at']
                   );
                !!}
            </div>
            <div class="form-group">
                <label for="members[{$member_idx}][decharged_at]">Decharge date</label>
                {!!
                   Form::date(
                       "members[{$member_idx}][decharged_at]",
                       optional($member)->decharged_at,
                       ['class' => 'form-control', 'id' => 'decharged_at']
                   );
                !!}
            </div>
        @endif
        @endif
    </div>
</li>

@push('scripts')
<script>
 (function() {
     var loadFile = function(event) {
         console.log(event);
         var reader = new FileReader();
         reader.onload = function(){
             var output = document.getElementById('{{ "members-photo[{$member_idx}]" }}');
             output.src = reader.result;
             console.log(output);
         };
         reader.readAsDataURL(event.target.files[0]);
     };

     var addBoardPhoto = document.getElementById('{{ "members[{$member_idx}][photo]" }}');
     addBoardPhoto.addEventListener('change', loadFile);

     console.log()
     var boardPhoto = document.getElementById('{{ "members-photo[{$member_idx}]" }}');
     boardPhoto.addEventListener('click', function() {
         addBoardPhoto.click();
     });
 })()
</script>
@endpush
