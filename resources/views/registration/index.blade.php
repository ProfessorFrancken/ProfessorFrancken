@extends('layout.one-column-layout')

@section('content')
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <h1 class="section-header section-header--centered mt-5">
        Register to be a Francken member
    </h1>

    <p class="lead text-center my-4">
        Will you be studying in Groningen and do you want to have a good time? Come and join our association!<br/>
        For only <strong>€5,- per year</strong> you can get free <strong>coffee and tea</strong> at our membersroom in the Nijenborgh 4 and join many of our activities, which is a great way to get to know your fellow students!
    </p>

    {!!
       Form::open(
           [
               'action' => [[\Francken\Association\Members\Http\Controllers\RegistrationController::class, 'store']] ,
           ]
       )
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

    {{--
        --}}
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

        <h4>Would you like to join a committee?</h4>
        <p>
            Many of our activities are organized by voluntary work from committees members.
            Joining a committee is a good opportunity to get to know your fellow students as well as improve your resume.
            You can find more information about each committee on our
            <a
                href="{{action([\Francken\Infrastructure\Http\Controllers\CommitteesController::class, 'index'])}}"
            >
                committees page
            </a>.
        </p>

        <div class="form-check">
            {!!
               Form::checkbox(
                   'wants_to_join_a_committee',
                   true,
                   false,
                   [
                       'id' => 'wants_to_join_a_committee',
                       'class' => 'form-check-input'
                   ]
               )
            !!}
            <label class="form-check-label" for="wants_to_join_a_committee">
                Yes I would like to join a committee!
            </label>
        </div>

        <h4 class="mt-3">
            Do you have any comments or questions? Let us know!
        </h4>
        <textarea name="comments" id="" rows="4" cols="" tabindex="" class="form-control" placeholder="Put your comments / questions here">

        </textarea>
    </fieldset>

    {!! Form::submit('Register', ['class' => 'btn btn-lg btn-block btn-outline-primary mb-5 register-section']) !!}

  {!! Form::close() !!}

<script>
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


@endsection
