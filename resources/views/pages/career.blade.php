@extends('homepage.one-column-layout')

@section('sub-menu')
    @include('layout._subnavigation', [
        'list' => [
            ['url' => "/career/job-openings", 'title' => 'Job openings'],
            ['url' => "/career/companies", 'title' => 'Company profiles'],
            ['url' => "/career/excursions", 'title' => 'Excursions'],
        ]
    ])
@endsection

@section('content')
  <h1>Career</h1>

  <p>Welcome to the carreer plaza of T.F.V. ‘Professor Francken’. Here you will find everything you need to prepare for your professional carreer. From excursions to job openings; this is where you will find everything that is relevant for your carreer.</p>

  <hr>

  <div class="row">
    <div class="col-md-7">
      <h2>Job openings</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      <a href="/career/job-openings" class="btn btn-primary">Read more</a>
    </div>
    <div class="col-md-5">
      <img data-holder-rendered="true" src="" alt="300x300" width="300" height="300">
    </div>
  </div>

  <hr>

  <div class="row">
    <div class="col-md-5">
      <img data-holder-rendered="true" src="" alt="300x300" width="300" height="300">
    </div>
    <div class="col-md-7">
      <h2>Company profiles</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      <a href="/career/companies" class="btn btn-primary">See all company profiles</a>
    </div>
  </div>

  <hr>

  <div class="row">
    <div class="col-md-7">
      <h2>Excursions</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      <a href="/career/excursions" class="btn btn-primary">See planned and previous excursions</a>
    </div>
    <div class="col-md-5">
      <img data-holder-rendered="true" src="" alt="300x300" width="300" height="300">
    </div>
  </div>

  <hr>

  <div class="row">
    <div class="col-md-5">
      <img data-holder-rendered="true" src="" alt="300x300" width="300" height="300">
    </div>
    <div class="col-md-7">
      <h2>LinkedIn</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      <a href="http://www.linkedin.com/groups/TFV-Professor-Francken-1524067" class="btn btn-primary">Go to our LinkedIn page</a>
    </div>
  </div>

  <hr>

@endsection

@section('header-image')
    @component('homepage.header._header_image')
    @slot('headerImageClass')
        header__registration-cta--small header__registration-cta--study
    @endslot

    @slot('image')
    http://www.professorfrancken.nl/wordpress/wp-content/uploads/2017/01/Oslo_willie-1080x400.jpg
    @endslot

    @endcomponent
@endsection
