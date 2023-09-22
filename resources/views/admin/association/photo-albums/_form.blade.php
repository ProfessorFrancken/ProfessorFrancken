<div class="row">
    <div class="col-12">
        @if (!$album->exists)
            <x-forms.select name='path' label="Album path"  :options="$albumDirectories" />
        @else
            {!! Form::hidden("path", $album->path) !!}
        @endif
        <x-forms.text name="title" label="Title" />
        <x-forms.textarea name="description" label="Description" help="The description is used to improve our Google search results. Should be 1 paragraph."/>

        <x-forms.date
            name="published_at"
            label="Published at"
            :value="optional($album->published_at)->format('Y-m-d')"
            min="{{ $year }}-01-01"
            max="{{ $year }}-12-31"
        />

        <x-forms.radio-group
            name='visibility'
            label="Visibility"
            :options="['members-only' => 'Members only', 'private' => 'Private', 'public' => 'Public']"
            help="Setting visibility to private makes the album and its photos no longer visible to users. Members only will make the album and its photos only visible to members that are logged in while public will be visible by anyone."
        />
        @if ($album->exists)
            <x-forms.checkbox name="update_visibility_of_photos">
                <x-slot name="label">
                    Update the visibility of all photos.
                </x-slot>
            </x-forms.checkbox>
        @endif
    </div>
</div>
