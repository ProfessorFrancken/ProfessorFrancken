<h4 class="font-weight-bold">
    Sign up settings
</h4>

<div class="row">
    <div class="col-6">
        <x-forms.datetime name="deadline_at" label="Sign up deadline" :value="optional($activity->start_date)->format('Y-m-d H:i:s')">
            <x-slot name="help">
                After this deadline only board members can sign up members
            </x-slot>
        </x-forms.datetime>
        <x-forms.number name="max_sign_ups" label="Max sign ups">
            <x-slot name="help">
                Set this field so that members can no longer sign up via our website if the maximum number of sign ups has been met.
                New attendees can still be signed up by a board member if this limit was met.
            </x-slot>
        </x-forms.number>
    </div>
    <div class="col-6">
        <x-forms.number name="costs_per_person" label="Costs per person">
            <x-slot name="help">
                Costs per person in cents (i.e. if the costs are &euro;5,-, fill in 500)
            </x-slot>
        </x-forms.number>
        <x-forms.number name="max_plus_ones_per_member" label="Max plus ones per member" />
        <x-forms.checkbox name="ask_for_dietary_wishes" label='Show a form field for dietary wishes when members sign up' />
        <x-forms.checkbox name="ask_for_drivers_license" label='Ask members if they have a drivers license' />
    </div>
</div>
