<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-6">
                    <x-forms.text name="firstname" label="Firstname" placeholder="Jan" required />
                </div>
                <div class="col-sm-6">
                    <x-forms.text name="surname" label="Surname" placeholder="Francken" required />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <x-forms.text name="initials" label="Initials" placeholder="J.C." />
            </div>
            <div class="col-sm-6">
                <x-forms.text name="position" label="Position" placeholder="Corporate reqruiter" />
            </div>
            <div class="col-sm-6">
                <x-forms.text name="title" label="Title" placeholder="Dr. Ir." />
            </div>
        </div>
        <div class="form-group">
            Gender
            <div class="d-flex flex-column flex-sm-row align-items-start mt-2">
                <div class="form-check mr-3">
                    {!!
                       Form::radio(
                           'gender',
                           'female',
                           false,
                           [
                               'id' => 'gender-female',
                               'class' => 'form-check-input',
                               'required',
                           ]
                       )
                    !!}
                    <label class="form-check-label" for='gender-female'>
                        Female
                    </label>
                </div>

                <div class="form-check mr-3">
                    {!!
                       Form::radio(
                           'gender',
                           'male',
                           false,
                           [
                               'id' => 'gender-male',
                               'class' => 'form-check-input'
                           ]
                       )
                    !!}
                    <label class="form-check-label mr-3" for='gender-male'>
                        Male
                    </label>
                </div>

                <div class="d-flex flex-column">
                    <div class="form-check">
                        {!!
                           Form::radio(
                               'gender',
                               'other',
                               false,
                               [
                                   'id' => 'gender-other',
                                   'class' => 'mr-2 form-check-input',
                               ]
                           )
                        !!}

                        <label class="form-check-label flex-grow-1 d-flex justify-content-between align-items-center" for='gender-other'>
                            Other / prefer not to share
                        </label>
                    </div>
                    <div class="mt-2">
                        {!!
                           Form::text(
                               'other_gender',
                               null,
                               [
                                   'placeholder' => "Other",
                                   'class' => 'form-control',
                               ]
                           )
                        !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-forms.textarea name="notes" label="Notes" rows="3">
    <x-slot name="help">
        Keep specific notes for this contact.
    </x-slot>
</x-forms.textarea>


<div class="d-flex flex-column justify-content-end h-100">
    <div>
        <img
            id="contact-photo"
            alt="Photo of {{ $contact->fullname }}"
            src="{{ optional($contact)->photo }}"
            class="mb-3 img-fluid rounded"
            style="object-fit: cover"
        />
    </div>

    <x-forms.image-upload
        name="photo"
        label="Contact logo"
        output-image-id="contact-photo"
    >
    </x-forms.image-upload>
</div>

@include('admin.extern.partners._contact_details_form', ['contactDetails' => $contact->contactDetails])
