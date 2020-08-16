<div class="row">
    <div class="col-6">

        @if ($signUp->member)
            {!!
                   Form::hidden(
                       'member_id',
                       $signUp->member_id,
                       ['class' => 'member_id']
                   )
            !!}
        @else
            <x-forms-autocomplete-member />
        @endif

        <x-forms.number name="plus_ones" label="Plus ones" />


        @if ($activity->signUpSettings->ask_for_dietary_wishes)
            <x-forms.text name="dietary_wishes" label="Dietary wishes" />
        @endif
        @if ($activity->signUpSettings->ask_for_drivers_license)
            <x-forms.checkbox name="has_drivers_license" label="Has drivers license" />
        @endif
    </div>
    <div class="col-6">
        <x-forms.textarea name="notes" label="Board notes" rows="4">
            <x-slot name="help">
                Use this field to keep track of any notes related to this member.
            </x-slot>
        </x-forms.textarea>
    </div>
</div>
