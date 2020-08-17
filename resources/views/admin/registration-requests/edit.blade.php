@extends('admin.layout')
@section('page-title', 'Registration requests / ' . $registration->fullname->toString() . ' / Edit')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    {!!
                       Form::model($registration, [
                           'url' => action(
                               [\Francken\Association\Members\Http\Controllers\Admin\RegistrationRequestsController::class, 'update'],
                               ['registration' => $registration->id]
                           ),
                           'method' => 'PUT',
                       ])
                    !!}

                    <fieldset class="register-section card card-body">
                        <legend class='mb-0'>
                            <h3 class="mb-0">
                                <i class="fa fa-address-book" aria-hidden="true"></i>
                                Step 1 / 4: Personal details
                            </h3>
                        </legend>

                        @include('registration._personal-details')
                    </fieldset>

                    <fieldset class="register-section card card-body">
                        <legend class='mb-0'>
                            <h3 class="mb-0">
                                <i class="fa fa-home" aria-hidden="true"></i>
                                Step 2 / 4: Contact details
                            </h3>
                        </legend>

                        @include('registration._contact-details')
                    </fieldset>

                    <fieldset class="register-section card card-body">
                        <legend class='mb-0'>
                            <h3 class="mb-0">
                                <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                Step 3 / 4: Study details
                            </h3>
                        </legend>

                        @include('registration._study-details')
                    </fieldset>

                    <fieldset class="register-section card card-body">
                        <legend class='mb-0'>
                            <h3 class="mb-0">
                                <i class="fas fa-money-check-alt" aria-hidden="true"></i>
                                Step 4 / 4: Billing details
                            </h3>
                        </legend>

                        @include('registration._billing-details')
                    </fieldset>

                    <fieldset class="register-section card card-body">
                        <legend class='mb-0'>
                            <h3 class="mb-0">
                                <i class="fa fa-users" aria-hidden="true"></i>
                                Become an active member
                            </h3>
                        </legend>

                        <x-forms.checkbox
                            name="wants_to_join_a_committee"
                            label="Yes I would like to join a committee!"
                            :value="isset($registration) ? $registration->wants_to_join_committee : false"
                        />

                        <x-forms.textarea name="comments" label="Comments" rows="4" />
                    </fieldset>
                </div>
                <div class="card-footer">
                    {!! Form::submit('Save', ['class' => 'btn btn-outline-success']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection



@push('scripts')
<script type="text/javascript">
 var addStudy = document.querySelector('#addAdditionalStudy');
 var studies = document.querySelector('.studies');

 function newStudyHtml()
 {
     return `<div class="form-group row">
                    <div class="col-sm-3">
                        <label for="study">Study</label>
                        <input placeholder="Bsc Applied Physics" class="form-control" name="study_name[]" type="text" required>
                    </div>
                    <div class="col-sm-3">
                        <label for="starting-date-study">Starting date</label>
                        <input placeholder="yyyy-mm" class="form-control" name="study_starting_date[]" type="month" required>
                    </div>
                    <div class="col-sm-3">
                        <label for="starting-date-study">Graduation date (optional)</label>
                        <input placeholder="yyyy-mm" class="form-control" name="study_graduation_date[]" type="month">
                    </div>
                    <div class="col-sm-3 d-flex">
                        <button class="remove-study btn btn-secondary align-self-end">
                            <i class="fa fa-times" aria-hidden="true"></i>
                            Cancel
                        </button>
                    </div>
                </div>`;
 }

 addStudy.addEventListener('click', function(e) {
     e.preventDefault();
     e.stopPropagation();

     var li = document.createElement("li");
     li.innerHTML = newStudyHtml();
     var button = li.querySelector('.remove-study');
     button.addEventListener('click', function(btnEvent) {
         btnEvent.preventDefault();
         btnEvent.stopPropagation();
         li.parentNode.removeChild(li);
     });

     studies.appendChild(li);

     var study = li.querySelector('input[name="study"]');
     study.focus();
 });

</script>
@endpush

@section('actions')
    <div class="d-flex align-items-start">
        <a
            class="btn btn-outline-primary mr-3"
            href="{{ action(
                       [\Francken\Association\Members\Http\Controllers\Admin\RegistrationRequestsController::class, 'show'],
                       ['registration' => $registration->id]
                   ) }}"
        >
            Back
        </a>
    </div>
@endsection
