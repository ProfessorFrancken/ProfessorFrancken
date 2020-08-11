<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-6">
                    <label for="firstname">Firstname</label>
                    {!!
                       Form::text(
                           'firstname',
                           null,
                           [
                               'placeholder' => 'Jan',
                               'class' => 'form-control',
                               'required'
                           ]
                       )
                    !!}
                    @error('firstname')
                    <p class="invalid-feedback">
                        {{ $message  }}
                    </p>
                    @enderror
                </div>
                <div class="col-sm-6">
                    <label for="firstname">Surname</label>
                    {!!
                       Form::text(
                           'surname',
                           null,
                           [
                               'placeholder' => 'Francken',
                               'class' => 'form-control',
                               'required',
                           ]
                       )
                    !!}
                    @error('surname')
                    <p class="invalid-feedback">
                        {{ $message  }}
                    </p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <label for="initials">Initials</label>
                {!!
                   Form::text(
                       'initials',
                       null,
                       [
                           'placeholder' => 'J.C.',
                           'class' => 'form-control',
                       ]
                   )
                !!}
                @error('firstname')
                <p class="invalid-feedback">
                    {{ $message  }}
                </p>
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="position">Position</label>
                {!!
                   Form::text(
                       'position',
                       null,
                       [
                           'placeholder' => 'Corporate recuiter',
                           'class' => 'form-control',
                           'id' => 'position'
                       ]
                   )
                !!}
                @error('position')
                <p class="invalid-feedback">
                    {{ $message  }}
                </p>
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="title">Title</label>
                {!!
                   Form::text(
                       'title',
                       null,
                       [
                           'placeholder' => 'Dr. Ir.',
                           'class' => 'form-control',
                           'id' => 'title'
                       ]
                   )
                !!}
                @error('title')
                <p class="invalid-feedback">
                    {{ $message  }}
                </p>
                @enderror
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

<div class="form-group">
    <label for="notes">Notes</label>
    {!!
       Form::textarea(
           'notes',
           null,
           ['class' => 'form-control', 'id' => 'notes', 'rows' => 3]
       )
    !!}
    <small class="form-text text-muted">
        Keep specific notes for this contact.
    </small>
</div>


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
