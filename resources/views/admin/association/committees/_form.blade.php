<div class="row">
    <div class="col">
        <div class="row">
            <div class="col-3">
                <div class="d-flex flex-column justify-content-end h-100">
                    <div>
                        <img
                            id="committee-logo"
                            alt="Logo of the committee"
                            src="{{ optional($committee)->logo }}"
                            class="mb-3 img-fluid rounded"
                            style="object-fit: cover"
                        />
                    </div>

                    <x-forms.image-upload
                        name="logo"
                        label="Committee logo"
                        output-image-id="committee-logo"
                    >
                        <x-slot name="help">
                            <small  class="form-text text-muted">
                                We will use this photo when displaying the committee's photo in the company profiles pages.
                            </small>
                        </x-slot>
                    </x-forms.image-upload>
                </div>
            </div>
            <div class="col">
                <x-forms.text name="name" label="Name" placeholder="S[ck]rip(t|t?c)ie" required />
                <x-forms.email name="email" label="Email" placeholder="kathinka@scriptcie.nl" />
                <x-forms.text name="goal" label="Goal" placeholder="Digital anarchy at Francken">
                    <x-slot name="help">
                        Fill in a short description of the committee.
                        This text is used as a description for the committee page and will be shown in google search results.
                    </x-slot>
                </x-forms.text>

                <x-forms.checkbox name="is_public" label="Show committee page on website" />
                <x-forms.select
                    name="parent_committee_id"
                    label="Parent committee"
                    placeholder="Select a committee from a previous board year"
                    :options="$parent_committees"
                >
                    <x-slot name="help">
                        Setting the parent committee to a pervious committee will allow us to suggest members for this committee based on its previous committee members.
                    </x-slot>
                </x-forms.select>
            </div>

            <div class='col-12'>
                <div class="d-flex flex-column justify-content-end h-100">
                    <div>
                        <img
                            id="committee-photo"
                            alt="Photo of the committee"
                            src="{{ optional($committee)->photo }}"
                            class="mb-3 img-fluid rounded"
                            style="object-fit: cover"
                        />
                    </div>
                    <x-forms.image-upload
                        name="photo"
                        label="Committee photo"
                        output-image-id="committee-photo"
                    >
                        <x-slot name="help">
                            <small  class="form-text text-muted">
                                We will use this photo when displaying the committee's photo in the company profiles pages.
                            </small>
                        </x-slot>
                    </x-forms.image-upload>
                </div>
            </div>
        </div>

        <x-forms.markdown />
    </div>
</div>
