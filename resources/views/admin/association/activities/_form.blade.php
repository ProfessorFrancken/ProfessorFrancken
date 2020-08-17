<div class="alert alert-warning" role="alert">
    Making changes to activities via this ui is currently disabled. Use the Google Calendar to change a description, date etc.
    We update the activities hourly based on the current google calendar.
</div>

<div class="row">
    <div class="col-6">
        <h4 class="font-weight-bold">
            Activity
        </h4>
        <div class="row">
            <div class="col-6">
                <x-forms.text name="name" label="Name" placeholder="Bitterballen borrel" disabled />
            </div>
            <div class="col-6">
                <x-forms.text name="location" label="Location" placeholder="Franckenroom" disabled />
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <x-forms.datetime name="start_date" label="Start date" disabled />
            </div>

            <div class="col-6">
                <x-forms.datetime name="end_date" label="End date" disabled />
            </div>
        </div>

        <x-forms.text name="summary" label="Summary" disabled>
            <x-slot name="help">
                This text is shown in the agenda on the front page.
            </x-slot>
        </x-forms.text>
    </div>
    <div class="col-6">
        <x-forms.markdown />
    </div>
</div>
