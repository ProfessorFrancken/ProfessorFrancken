<x-forms.text name="fullname" label="Fullname" />
<x-forms.text name="study" label="Study" />
<x-forms.number name="graduation_year" label="Graduation year" />

@if ($alumnus->member)
    {!!
           Form::hidden(
               'member_id',
               $alumnus->member_id,
               ['class' => 'member_id']
           )
    !!}
@else
    <p class="text-muted"><strong>Note</strong>: the field below is optional, we could use this to keep track of active members that attended the activity.</p>
    <x-forms-autocomplete-member />
@endif
