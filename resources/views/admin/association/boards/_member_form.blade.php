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

        <x-forms.text :name='"members[{$member_idx}][title]"' label="Title" :value="optional($member)->title" />

        @if ($board->exists)
            <x-forms.date
                :name='"members[{$member_idx}][installed_at]"'
                label="Install date"
                :value="optional($member)->installed_at"
            />
            @if ($member->exists)
                <x-forms.date
                    :name='"members[{$member_idx}][demissioned_at]"'
                    label="Demissioned date"
                    :value="optional($member)->demissioned_at"
                />
                <x-forms.date
                    :name='"members[{$member_idx}][decharged_at]"'
                    label="Decharge date"
                    :value="optional($member)->decharged_at"
                />
            @endif
        @endif
    </div>
</li>
