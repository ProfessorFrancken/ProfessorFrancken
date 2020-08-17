<x-forms.text name="display_name" label="Display name">
    <x-slot name="help">
        Set a custom display name if this partner has a name such as "Thales Nederland B.V." and you'd rather show "Thales" when the partner is viewed on the website.
    </x-slot>
</x-forms.text>
<x-forms.checkbox name="is_enabled" label="Show on website" :value="$profile->is_enabled" />
<x-forms.markdown />
