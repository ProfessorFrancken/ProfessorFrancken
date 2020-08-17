<x-forms-autocomplete-member
    :value="isset($alumnus) ? optional($alumnus->member)->fullname : null"
    :value-id="isset($alumnus) ? optional($alumnus->member)->id : null"
/>
<x-forms.text name="position" label="Position / job title" :value="$alumnus->position" />
<x-forms.date
    name="started_position_at"
    label="Started position at"
    :value="optional($alumnus->started_position_at)->format('Y-m-d')"
/>
<x-forms.date
    name="stopped_position_at"
    label="Stopped position at"
    :value="optional($alumnus->stopped_position_at)->format('Y-m-d')"
/>
<x-forms.textarea name="notes" label="notes" rows="3">
    <x-slot name="help">
        Keep specific notes for this alumnus.
    </x-slot>
</x-forms.textarea>
