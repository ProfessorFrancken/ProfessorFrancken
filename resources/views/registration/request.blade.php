@extends('homepage.one-column-layout')

@section('header-image')
    @component('homepage.header._header_image')
    {{--
    <h1 class="section-header section-header--centered">
        Step 1 / 5<br />
        <small>
            Contact Details
        </small>
    </h1>
      --}}
    @endcomponent

@endsection

@section('content')
    <h1 class="section-header section-header--centered">
        Register to be a Francken member
    </h1>

    <p class="lead text-center my-4">
        Will you be studying in Groningen and do you want to have a good time? Come and join our association.<br/>
        At the cost of €5,- per year you can get free <strong>coffee and tea</strong> at our membersroom in the Nijenborgh 4 and join many of our activities which is a great way to get to know your fellow students!
    </p>

  {!! Form::open(['url' => 'register', 'files' => true]) !!}
  {!! csrf_field() !!}

    <style>

        .register-section {
            margin: 2em 0 ;
            /* padding: 1em; */
            /* border: thin solid #fefefe; */
            background: #fefefe;
        }

     .register-section .progress {
         margin-bottom: 2em;
         display:none;
     }

     .register-section .progress-bar {
         height: 3em;
     }

    </style>

    {{--

        --}}

    <fieldset class="register-section card card-block">
    <legend>
        <h3>
            <i class="fa fa-address-book" aria-hidden="true"></i>
            Step 1 / 4: Personal details
        </h3>
    </legend>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
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
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        @include('registration._contact-details')
    </fieldset>

    <fieldset class="register-section card card-block">
    <legend>
        <h3>
            <i class="fa fa-graduation-cap" aria-hidden="true"></i>
            Step 3 / 4: Study details
        </h3>
    </legend>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        @include('registration._study-details')
    </fieldset>

    <fieldset class="register-section card card-block">
    <legend>
        <h3>
            <i class="fa fa-money" aria-hidden="true"></i>
            Step 4 / 4: Billing details
        </h3>
    </legend>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        @include('registration._billing-details')
    </fieldset>

    {!! Form::submit('Submit request', ['class' => 'btn btn-lg btn-block btn-primary mb-5']) !!}
  {!! Form::close() !!}

@endsection
