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

        <x-forms.image-upload
            :name='"members[{$member_idx}][photo]"'
            :output-image-id='"members-photo[{$member_idx}]"'
            label="Board member photo"
        />

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
