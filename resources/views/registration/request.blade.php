@extends('layout.one-column-layout')

@section('content')
    <h1 class="section-header section-header--centered">
        Register to be a Francken member
    </h1>

    <p class="lead text-center my-4">
        Will you be studying in Groningen and do you want to have a good time? Come and join our association.<br/>
        At the cost of €5,- per year you can get free <strong>coffee and tea</strong> at our membersroom in the Nijenborgh 4 and join many of our activities which is a great way to get to know your fellow students!
    </p>

  {!! Form::open(['url' => 'register', 'files' => true]) !!}

    <fieldset class="register-section card card-block">
        <legend>
            <h3>
                <i class="fa fa-address-book" aria-hidden="true"></i>
                Step 1 / 4: Personal details
            </h3>
        </legend>

        @include('registration._personal-details')
    </fieldset>

    {{--
        --}}
    <fieldset class="register-section card card-block">
        <legend>
            <h3>
                <i class="fa fa-home" aria-hidden="true"></i>
                Step 2 / 4: Contact details
            </h3>
        </legend>

        @include('registration._contact-details')
    </fieldset>

    <fieldset class="register-section card card-block">
        <legend>
            <h3>
                <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                Step 3 / 4: Study details
            </h3>
        </legend>

        @include('registration._study-details')
    </fieldset>

    <fieldset class="register-section card card-block">
        <legend>
            <h3>
                <i class="fa fa-money" aria-hidden="true"></i>
                Step 4 / 4: Billing details
            </h3>
        </legend>

        @include('registration._billing-details')
    </fieldset>

    {!! Form::submit('Submit request', ['class' => 'btn btn-lg btn-block btn-primary mb-5']) !!}

  {!! Form::close() !!}

    {{--
<script src="https://unpkg.com/react@15/dist/react.js"></script>
<script src="https://unpkg.com/react-dom@15/dist/react-dom.js"></script>
    --}}

<script>
 var loadFile = function(event) {
     var reader = new FileReader();
     reader.onload = function(){
         var output = document.getElementById('profilePicture');
         output.src = reader.result;
     };
     console.log(event);
     reader.readAsDataURL(event.target.files[0]);
 };

 var addProfilePicture = document.querySelector('#addProfilePicture');
 addProfilePicture.addEventListener('change', loadFile);

 var profilePicture = document.getElementById('profilePicture');
 profilePicture.addEventListener('click', function() {
     addProfilePicture.click();
 });
</script>

{{--

We will probably switch to a React component

<button class="btn btn-link" id="addAdditionalStudy">
<i class="fa fa-plus-circle" aria-hidden="true"></i>
Add another study
</button>
--}}

<script>
 var addStudy = document.querySelector('#addAdditionalStudy');
 var studies = document.querySelector('.studies');

 function newStudyHtml()
 {
     return `<div class="form-group row">
                    <div class="col-sm-3">
                        <label for="study">Study</label>
                        <input placeholder="Bsc Applied Physics" class="form-control" name="studies[]name[]" type="text" required>
                    </div>
                    <div class="col-sm-3">
                        <label for="starting-date-study">Starting date</label>
                        <input placeholder="yyyy-mm" class="form-control" name="studies[]starting-date[]" type="month" required>
                    </div>
                    <div class="col-sm-3">
                        <label for="starting-date-study">Graduation date (optional)</label>
                        <input placeholder="yyyy-mm" class="form-control" name="studies[]graduation-date[]" type="month">
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
