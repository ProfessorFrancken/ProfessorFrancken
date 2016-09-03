@extends('home-layout')


@section('content')
  <h1><strong>You</strong> should become a Francken Member!</h1>
  <p>
    Ut faucibus pulvinar elementum integer enim neque, volutpat ac tincidunt vitae, semper! Ac ut consequat semper viverra nam libero justo, laoreet sit amet cursus sit amet, dictum sit amet justo?
  </p>
  <ul>
    <li><strong>Study</strong>: Nisl nisi, scelerisque eu ultrices vitae, auctor eu augue ut lectus arcu, bibendum! Mauris ultrices eros, in cursus turpis massa tincidunt dui ut ornare lectus sit amet est placerat in.</li>
    <li><strong>Social</strong>: Sapien eget mi proin sed libero enim, sed faucibus turpis in eu mi bibendum neque egestas congue quisque egestas diam in arcu cursus. Quam pellentesque nec nam aliquam sem et!</li>
    <li><strong>Career</strong>: Neque aliquam vestibulum morbi blandit cursus risus, at? Tortor dignissim convallis aenean et tortor at risus viverra adipiscing at in tellus integer feugiat scelerisque varius morbi enim nunc, faucibus a.</li>
  </ul>
  <p>
    Submit the form below to the members of our board.
  </p>

  {!! Form::open(['url' => 'register', 'files' => true]) !!}
  {!! csrf_field() !!}
  <fieldset class="card card-block">
    <legend>
      <h2>Membership form</h2>
    </legend>
    @include('registration._personal-details')
    @include('registration._contact-details')
    @include('registration._study-details')

    <hr>
    @include('registration._billing-details')
    <hr>

    {!! Form::submit('Submit request', ['class' => 'btn btn-lg btn-block btn-success']) !!}
  </fieldset>
  {!! Form::close() !!}

@endsection
