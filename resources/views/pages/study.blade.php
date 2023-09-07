@extends('layout.one-column-layout')
@section('title', "Study - T.F.V. 'Professor Francken'")
@section('description', "As a study association T.F.V. 'Professor Francken' organizes plethora of activities related to (applied) physics, including symposia, (research group) excursions, practice sessions for exams.")

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
            <a href="/study/books">
                <img
                    alt="Buy second-hand study books"
                    src="{{ image('https://professorfrancken.nl/images/header/library-books.jpeg', ['height' => 150, 'width' => 150]) }}"
                    class="mb-3 rounded-circle"
                />

                <h2>Books</h2>
                <p>Buy and sell second-hand books!</p>
            </a>
        </div>

        <div style="text-align: center" class="col-md-4">
            <a href="/study/research-groups">
                <img
                    alt="Research groups associated to applied physics at the University of Groningen"
                    src="{{ image('https://www.rug.nl/research/zernike/images/cleanroom2_2.jpg', ['height' => 150, 'width' => 150]) }}"
                    class="mb-3 rounded-circle"
                />


                <h2>Research Groups</h2>
                <p>Information about the research groups of applied physics.</p>
            </a>
        </div>

        <div style="text-align: center" class="col-md-4">
            <a href="/study/representation/university-council">
                <img
                    alt="University council of the University of Groningen"
                    src="{{ image('http://www.alsalammasjid.org/wp-content/uploads/2017/05/council.jpg', ['height' => 150, 'width' => 150]) }}"
                    class="mb-3 rounded-circle"
                />

                <h2>University Council</h2>
                <p>Information about the University Council.</p>
            </a>
        </div>

        <div style="text-align: center" class="col-md-4">
            <a href="/study/representation/faculty-council">
                <img
                    alt="Faculty council of the University of Groningen"
                    src="{{ image('/images/faculty_council.jpg', ['height' => 150, 'width' => 150], true) }}"
                    class="mb-3 rounded-circle"
                />

                <h2>Faculty Council</h2>
                <p>Information about the Faculty Council.</p>
            </a>
        </div>

    </div>

@endsection
