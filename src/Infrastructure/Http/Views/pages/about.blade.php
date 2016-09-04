@extends('base-layout')

@section('sub-menu')
    @include('layout._subnavigation', [
        'list' => [
            ['url' => "/about/history", 'title' => 'History'],
            ['url' => "/about/honorary-members", 'title' => 'Honerary members'],
            ['url' => "/about/boards", 'title' => 'Boards'],
            ['url' => "/about/committees", 'title' => 'Committees'],
            ['url' => "/about/francken-vrij", 'title' => 'Francken Vrij'],
        ]
    ])
@endsection

@section('content')

  <h1>About</h1>

  <p>The Technisch Fysische Vereniging ‘Professor Francken’ (Applied Physics Association ‘Professor Francken’) is the University of Groningen’s study association for applied physics and it is focused on (graduated) applied physics students. Other students of the faculty can become a donator of the association. They have the same privileges as applied physics students, except the right to vote at the general members assembly (ALV).

  <p>The association was founded in 1968 as the “Vereniging van Toekomstige Ingenieurs” (Association of Future Engineers). At that time it was uncertain whether applied physics graduates would be granted the qualification ‘ingenieur’. This changed for the Groningen technicians as a result of a Royal Decree of 18 November 1971. The association changed its name to V.K.T.N., or Vereniging voor Kandidaten Technische Natuurkunde (Association for Candidates Applied Physics). In 1984 the association was named after the first professor in applied physics in Groningen: prof. dr. ir. J.C. Francken.</p>

  <a class="btn btn-default" href="/about/history">Read more history</a>

  <hr>

  <div class="row">
    <div style="text-align: center" class="col-md-4">
      <div style="height: 150px; width: 150px; border-radius: 50%; background-color: grey; margin: auto"></div>
      <h2>Boards</h2>
      <p>List of all previous boards and ‘Wijze Heeren en Damesch’.</p>
    </div>

    <div style="text-align: center" class="col-md-4">
      <div style="height: 150px; width: 150px; border-radius: 50%; background-color: grey; margin: auto"></div>
      <h2>Committees</h2>
      <p>List of all committees</p>
    </div>

    <div style="text-align: center" class="col-md-4">
      <div style="height: 150px; width: 150px; border-radius: 50%; background-color: grey; margin: auto"></div>
      <h2>Francken Vrij</h2>
      <p>Look here for our magazine.</p>
    </div>
  </div>

  <hr>

  <div class="row">
    <div class="col-md-5">
      <img src="http://www.professorfrancken.nl/wordpress/media/images/besturen/bestuur_1617.jpg" alt="figure" width="100%">
    </div>
    <div class="col-md-7">
      <h2>Board</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      <a href="/about/boards" class="btn btn-default">List of all previous boards</a>
    </div>
  </div>

  <hr>

  <div class="row">
    <div class="col-md-9">
      <h2>Honerary members</h2>
      <p>T.F.V. ‘Professor Francken’ has the honour to have two very much appreciated physicists as honorary members. Of course professor J.C. Francken, after whom we named the association, is an honorary member. And of course professor J.Th.M. De Hosson became an honorary member on basis of his special merit towards the association</p>
      <a href="/about/honorary-members" class="btn btn-default">Read more</a>
    </div>
    <div class="col-md-3">
      <img src="http://www.professorfrancken.nl/wordpress/media/images/ereleden/profjcfrancken.png" alt="figure" width="100%">
    </div>
  </div>

  <hr>

@endsection
