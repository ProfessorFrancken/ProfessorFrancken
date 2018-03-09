@extends('layout.one-column-layout')
@section('title', "Association - T.F.V. 'Professor Francken'")
@section('description', "The Technisch Fysische Vereniging ‘Professor Francken’ (Applied Physics Association ‘Professor Francken’) is the University of Groningen’s study association for applied physics and it is focused on (graduated) applied physics students.")

@section('content')

    <h1 class="section-header">Association</h1>

    <p>
      The Technisch Fysische Vereniging ‘Professor Francken’ (Applied Physics Association ‘Professor Francken’) is the University of Groningen’s study association for engineering physics and it is focused on (graduated) applied physics students and students of closely related tracks study tracks.
     Other students of the faculty can become a donator of the association. They have the same privileges as applied physics students, except the right to vote at the general members assembly (ALV).
    </p>

        <p>The association was founded in 1968 as the “Vereniging van Toekomstige Ingenieurs” (Association of Future Engineers). At that time it was uncertain whether applied physics graduates would be granted the qualification ‘ingenieur’. This changed for the Groningen technicians as a result of a Royal Decree of 18 November 1971. The association changed its name to V.K.T.N., or Vereniging voor Kandidaten Technische Natuurkunde (Association for Candidates Applied Physics). In 1984 the association was named after the first professor in applied physics in Groningen: prof. dr. ir. J.C. Francken.</p>

        <hr>

        <div class="row">
            <div style="text-align: center" class="col-md-4">
                <a href="/association/news">
                    <img
                        alt="News related to Francken and other associations"
                        src="{{ image('http://borrelcie.vodka/img/bcie1516.JPG', ['height' => 150, 'width' => 150]) }}"
                        class="mb-3 rounded-circle"
                        style="height: 150px; width: 150px; object-fit: contain"
                    />
                    <h2>News</h2>
                    <p>Follow Francken closely and get provided all Francken news</p>
                </a>
            </div>

            <div style="text-align: center" class="col-md-4">
                <a href="/association/history">
                    <img
                        alt="History of Francken"
                        src="{{ image('https://pbs.twimg.com/profile_images/614489310428012544/m5PFdI4G.jpg', ['height' => 150, 'width' => 150]) }}"
                        class="mb-3 rounded-circle"
                    />
                    <h2>History</h2>
                    <p>Learn more about the history of Francken!</p>
                </a>
            </div>

            <div style="text-align: center" class="col-md-4">
                <a href="/association/honorary-members">
                    <img
                        alt="Current and previous boards of T.F.V. 'Professor Francken'"
                        src="{{ image('https://professorfrancken.nl//images/prof-jan-carel-francken.png', ['height' => 150, 'width' => 150]) }}"
                        class="mb-3 rounded-circle"
                    />
                    <h2>Honorary members</h2>
                    <p>Learn more about our honorary members</p>
                </a>
            </div>

            <div style="text-align: center" class="col-md-4">
                <a href="/association/boards">
                    <img
                        alt="Current and previous boards of T.F.V. 'Professor Francken'"
                        src="{{ image('https://professorfrancken.nl/images/boards/he_watt.jpg', ['height' => 150, 'width' => 150]) }}"
                        class="mb-3 rounded-circle"
                    />
                    <h2>Boards</h2>
                    <p>List of all previous boards and ‘Wijze Heeren en Damesch’.</p>
                </a>
            </div>

            <div style="text-align: center" class="col-md-4">
                <a href="/association/committees">
                    <img
                        alt="Current and previous boards of T.F.V. 'Professor Francken'"
                        src="{{ image('https://professorfrancken.nl/images/LOGO_KAAL.png', ['height' => 150, 'width' => 150]) }}"
                        class="mb-3 rounded-circle"
                        style="width: 150px; height: 150px; object-fit: contain"
                    />
                    <h2>Committees</h2>
                    <p>Francken has a lot of fascinating commmittees. Come and see yourself.</p>
                </a>
            </div>

            <div style="text-align: center" class="col-md-4">
                <a href="/association/francken-vrij">
                    <img
                        alt="Current and previous boards of T.F.V. 'Professor Francken'"
                        src="{{ image('https://professorfrancken.nl/images/francken-vrij-homepage.png', ['height' => 150, 'width' => 150]) }}"
                        class="mb-3 rounded-circle"
                    />
                    <h2>Francken Vrij</h2>
                    <p>
                        The popular science magazine of the Technisch Fysische Vereniging ‘Professor Francken'.
                    </p>
                </a>
            </div>
        </div>
@endsection
