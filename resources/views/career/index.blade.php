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

  <hr class="my-5">

  <div class="row">
    <div style="text-align: center" class="col-md-4">

        <a href="/career/job-openings">
            <img
                alt="Find job openings and internships related to applied physics"
                src="{{ image('https://cdn.pixabay.com/photo/2016/10/04/13/52/hire-1714369_960_720.jpg', ['height' => 150, 'width' => 150]) }}"
                class="mb-3 rounded-circle"
                style="height: 150px; width: 150px; object-fit: contain"
            />
            <h2>Job openings</h2>
            <p>
                Find job openings and internships related to applied physics
            </p>
        </a>
    </div>

    <div style="text-align: center" class="col-md-4">
        <a href="/career/companies">
            <img
                alt="Companies related to applied physics"
                src="{{ image('https://upload.wikimedia.org/wikipedia/en/1/11/Inside_Aryogen.jpg', ['height' => 150, 'width' => 150]) }}"
                class="mb-3 rounded-circle"
                style="height: 150px; width: 150px; object-fit: contain"
            />
            <h2>Company profiles</h2>
            <p>
                Companies related to applied physics
            </p>
        </a>
    </div>

    <div style="text-align: center" class="col-md-4">
        <a href="/association/events">
            <img
                alt="A typical Sanning Electron Microscope"
                src="{{ image('https://upload.wikimedia.org/wikipedia/commons/3/3b/SEM_chamber1.JPG', ['height' => 150, 'width' => 150]) }}"
                class="mb-3 rounded-circle"
                style="height: 150px; width: 150px; object-fit: contain"
            />
            <h2>Excursions </h2>
            <p>
                An overview of excursions to research groups and companies
            </p>
        </a>
    </div>

    <div style="text-align: center" class="col-md-4">
        <a href="https://www.linkedin.com/groups/1524067">
            <img
                alt="Stay in touch with our alumni on LinkedIn"
                src="{{ image('https://upload.wikimedia.org/wikipedia/commons/thumb/c/ce/Linkedin_circle.svg/2000px-Linkedin_circle.svg.png', ['height' => 150, 'width' => 150]) }}"
                class="mb-3 rounded-circle"
                style="height: 150px; width: 150px; object-fit: contain"
            />
            <h2>LinkedIn</h2>
            <p>
                Stay in touch with our alumni on LinkedIn.
            </p>
        </a>
    </div>
  </div>

  <hr class="my-5">

@endsection
