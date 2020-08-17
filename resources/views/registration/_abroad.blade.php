<h4>Studying from abroad?</h4>
<p class="text-muted">
    We would like to keep track of the amount of international members, please provide your nationality and indicate if you've got a Dutch high school diploma.
</p>
<x-forms.checkbox
    name="no_dutch_high_school_diploma"
    label="I don't have a Dutch high school diploma"
    placeholder="Jan"
    :value='isset($registration) ? ! $registration->has_dutch_diploma : false'
/>
<x-forms.text name="nationality" label="Nationality" placeholder="Netherlands" />
