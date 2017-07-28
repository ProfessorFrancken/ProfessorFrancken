@extends('homepage.one-column-layout')

@section('header-image-url', '/images/header/oslo.jpg')
@section('title', "Career - T.F.V. 'Professor Francken'")

@section('content')

  <h1 class="section-header">Career</h1>

  <p>
      At T.F.V. 'Professor Francken' we aim to help students prepare for their professional career after their studies.
      We do this by organizing <a href="/career/events">lunch lectures, excursions, symposia and other career related activities</a>.
      Additionally we have large network of alumni students that work at various companies whom might be of help when you're looking for a <a href="/career/job-openings">job or an internship</a>.
  </p>

  <hr>

  <div class="row">
    <div style="text-align: center" class="col-md-4">
      <div style="height: 150px; width: 150px; border-radius: 50%; background-color: grey; margin: auto"></div>
      <h2>Job openings</h2>
    </div>

    <div style="text-align: center" class="col-md-4">
      <div style="height: 150px; width: 150px; border-radius: 50%; background-color: grey; margin: auto"></div>
      <h2>Company profiles</h2>
      <p>Company profiles of our partners!</p>
    </div>

    <div style="text-align: center" class="col-md-4">
      <div style="height: 150px; width: 150px; border-radius: 50%; background-color: grey; margin: auto">
      <img src="/images/prof-jan-carel-francken.png" style="height: 150px; width: 150px; border-radius: 50%; background-color: grey; margin "></div>

      <h2>Excursions </h2>
      <p>An overview of excursions to research groups and companies</p>
    </div>

    <div style="text-align: center" class="col-md-4">
      <div style="height: 150px; width: 150px; border-radius: 50%; background-color: grey; margin: auto"></div>
      <h2>LinkedIn</h2>
      <p>Stay in touch with our alumni on LinkedIn.</p>
    </div>
  </div>

  <hr>

@endsection
