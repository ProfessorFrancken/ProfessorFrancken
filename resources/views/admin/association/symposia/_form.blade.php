<div class="row mt-4">
    <div class="col">
        <x-forms.text name="name" label="Name" placeholder="Cognitive Matters" />
        <x-forms.text name="location" label="Location" placeholder="Groningen" />
        <x-forms.text name="location_google_maps_url" label="Google maps url for location" placeholder="https://www.google.com/maps/dir/?api=1&destination=De+Pudding,+Viaductstraat,+3-3,+Groningen&travelmode=bicycling">
            <x-slot name="help">
                When we send an information email to participants of the symposium it will contain a link for directions toward the location. We use this url for that.
            </x-slot>
        </x-forms.text>
        <x-forms.text name="website_url" label="Website url" placeholder="https://franckensymposium.nl" />

        <x-forms.datetime name="start_date" label="Start date" :value="optional($symposium->start_date)->format('Y-m-d H:i')">
            <x-slot name="help">
                Should be in "YYYY-MM-DD HH:MM" format.
            </x-slot>
        </x-forms.date>
        <x-forms.datetime name="end_date" label="Start date" :value="optional($symposium->end_date)->format('Y-m-d H:i')">
            <x-slot name="help">
                Should be in "YYYY-MM-DD HH:MM" format.
            </x-slot>
        </x-forms.date>

        <x-forms.checkbox name="open_for_registration" label='Open for registration' />
        <x-forms.checkbox name="promote_on_agenda" label='Promote on agenda' />
    </div>

    <div class="col-3">
        <div class="d-flex flex-column h-100">
            <div>
                <img
                    id="symposium-logo"
                    alt="Logo of the symposium"
                    src="{{ optional($symposium)->logo }}"
                    class="mb-3 img-fluid rounded"
                    style="object-fit: cover"
                />
            </div>

            <x-forms.image-upload
                name="logo"
                label="Symposium logo"
                output-image-id="symposium-logo"
            >
                <x-slot name="help">
                    <small  class="form-text text-muted">
                        The symposium's logo is used in emails send to participants.
                    </small>
                </x-slot>
            </x-forms.image-upload>
        </div>
    </div>
</div>
