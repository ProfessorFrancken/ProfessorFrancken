@extends('homepage.one-column-layout')

@section('header-image-url', '/images/header/practice-session.jpg')
@section('content')

  <h1 class="section-header">Study</h1>

  <p>
      T.F.V. ‘Professor Francken’ organizes a plethora of activities related to (applied) physics, including symposia, (research group) excursions, practice sessions for exams.
      In addition to that we communicate regularly with many different university organs like the educations committees, the faculty councils and the university council.
  </p>

  <hr>
  <div class="row">
    <div style="text-align: center" class="col-md-4">
      <div style="height: 150px; width: 150px; border-radius: 50%; background-color: grey; margin: auto"></div>
      <h2>Books</h2>
      <p>Buy and sell second-hand books!</p>
    </div>

    <div style="text-align: center" class="col-md-4">
      <div style="height: 150px; width: 150px; border-radius: 50%; background-color: grey; margin: auto"></div>
      <h2>Research Groups</h2>
      <p>Information about the research groups of applied physics.</p>
    </div>

    <div style="text-align: center" class="col-md-4">
      <div style="height: 150px; width: 150px; border-radius: 50%; background-color: grey; margin: auto"></div>
      <h2>University Council</h2>
      <p>Information about the University Council.</p>
    </div>

    <div style="text-align: center" class="col-md-4">
      <div style="height: 150px; width: 150px; border-radius: 50%; background-color: grey; margin: auto"></div>
      <h2>Faculty Council</h2>
      <p>Information about the Faculty Council.</p>
    </div>

  </div>

@endsection
