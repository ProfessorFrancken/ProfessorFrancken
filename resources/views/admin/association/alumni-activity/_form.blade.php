@if ($alumnus->member)
    {!!
           Form::hidden(
               'member_id',
               $alumnus->member_id,
               ['class' => 'member_id']
           )
    !!}
@else
    <x-forms-autocomplete-member />
@endif

<x-forms.text name="fullname" label="Fullname" />
<x-forms.text name="study" label="Study" />
<x-forms.number name="graduation_year" label="Graduation year" />
