<x-forms.text name="title" label="Title" placeholder="Senior engineer" required />
<x-forms.text name="description" label="Description" placeholder="Doing engineering things" />
<x-forms.select
    name="sector_id"
    label="Sector"
    :value="$vacancy->sector_id ?? $partner->sector_id"
    :options="$sectors"
/>
<x-forms.select name="type" label="Type" :options="$types" required />
<x-forms.text
    name="vacancy_url"
    label="Vacancy url"
    placeholder="https://scriptcie.nl"
>
    <x-slot name="help">
        If no url was provided you may use the partner's website.
    </x-slot>
</x-forms.text>
