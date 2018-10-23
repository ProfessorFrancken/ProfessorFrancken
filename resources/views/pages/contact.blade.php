@extends('layout.one-column-layout')
@section('title', "Contact - T.F.V. 'Professor Francken'")
@section('description', "Contact information of the study association T.F.V. 'Professor Francken'.")

@section('content')
    <h1>Contact</h1>

    <div class="row">
        <div class="col-sm-4">
            <h2>Address</h2>

            <address>
                <h4>Correspondences adress</h4>
                T.F.V. ‘Professor Francken’<br>
                Nijenborgh 4<br>
                9747 AG Groningen
            </address>

            <address>
                <h4>Visiting address</h4>
                <strong>Board room</strong>: building 13, room 5113.0006<br>
                <strong>Members room</strong>: building 13, room 5113.0002<br>
            </address>
        </div>
        <div class="col-sm-4">
            <h2>Contact details</h2>

            <h4>Board</h4>
            <strong>Email</strong>: <a href="mailto:board@professorfrancken.nl">board@professorfrancken.nl</a><br>
            <strong>Phone</strong>: <a href="tel:+31503634978">+31 (0) 50 363 4978</a>

            <h4>External relations</h4>
            <strong>Email</strong>: <a href="mailto:extern@professorfrancken.nl" >extern@professorfrancken.nl</a><br>
            <strong>Phone</strong>: <a href="tel:+31650882750">+31 650882750</a>
        </div>
        <div class="col-sm-4">
            <h2>Other information</h2>

            <strong>K.v.K.</strong>: 400 252 71<br>
            <strong>IBAN</strong>: NL31 ABNA 0510 5771 56
        </div>
    </div>

@endsection
