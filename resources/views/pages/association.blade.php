@extends('homepage.one-column-layout')

@section('sub-menu')
    @include('layout._subnavigation', [
        'list' => [
            ['url' => "/association/history", 'title' => 'History'],
            ['url' => "/association/honorary-members", 'title' => 'Honerary members'],
            ['url' => "/association/boards", 'title' => 'Boards'],
            ['url' => "/association/committees", 'title' => 'Committees'],
            ['url' => "/association/francken-vrij", 'title' => 'Francken Vrij'],
        ]
    ])
@endsection

@section('content')

  <h1>Association</h1>

  <p>The Technisch Fysische Vereniging ‘Professor Francken’ (Applied Physics Association ‘Professor Francken’) is the University of Groningen’s study association for applied physics and it is focused on (graduated) applied physics students. Other students of the faculty can become a donator of the association. They have the same privileges as applied physics students, except the right to vote at the general members assembly (ALV).

  <p>The association was founded in 1968 as the “Vereniging van Toekomstige Ingenieurs” (Association of Future Engineers). At that time it was uncertain whether applied physics graduates would be granted the qualification ‘ingenieur’. This changed for the Groningen technicians as a result of a Royal Decree of 18 November 1971. The association changed its name to V.K.T.N., or Vereniging voor Kandidaten Technische Natuurkunde (Association for Candidates Applied Physics). In 1984 the association was named after the first professor in applied physics in Groningen: prof. dr. ir. J.C. Francken.</p>

  <hr>

  <div class="row">
    <div style="text-align: center" class="col-md-4">
      <div style="height: 150px; width: 150px; border-radius: 50%; background-color: grey; margin: auto"></div>
      <h2>News</h2>
      <p>Follow francken closely and get provided all Francken news</p>
    </div>

    <div style="text-align: center" class="col-md-4">
      <div style="height: 150px; width: 150px; border-radius: 50%; background-color: grey; margin: auto"></div>
      <h2>History</h2>
      <p>Learn more about the history of Francken!</p>
    </div>

    <div style="text-align: center" class="col-md-4">
      <div style="height: 150px; width: 150px; border-radius: 50%; background-color: grey; margin: auto">
      <img src="http://www.professorfrancken.nl/wordpress/media/images/ereleden/profjcfrancken.png" style="height: 150px; width: 150px; border-radius: 50%; background-color: grey; margin "></div>
      <h2>Honerary members</h2>
      <p>Learn more about our honerary members</p>
    </div>
    
    <div style="text-align: center" class="col-md-4">
      <div style="height: 150px; width: 150px; border-radius: 50%; background-color: grey; margin: auto"></div>
      <h2>Boards</h2>
      <p>List of all previous boards and ‘Wijze Heeren en Damesch’.</p>
    </div>
    
    <div style="text-align: center" class="col-md-4">
      <div style="height: 150px; width: 150px; border-radius: 50%; background-color: grey; margin: auto"></div>
      <h2>Committees</h2>
      <p>Francken has a lot of fascinating commmittees. Come and see yourself.</p>
    </div>
    
    <div style="text-align: center" class="col-md-4">
      <div style="height: 150px; width: 150px; border-radius: 50%; background-color: grey; margin: auto"></div>
      <h2>Francken Vrij</h2>
      <p>Learn more about the history of Francken!</p>
    </div>
  </div>

  <hr>

@endsection
