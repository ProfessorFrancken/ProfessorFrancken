<div class="container">
    <div class="row">
        <div class="col about-francken order-end order-1">
            <div class="about-francken__j-c-francken">
                <img alt="" src="{{ image("https://professorfrancken.nl/images/prof-jan-carel-francken.png", ['width' => 300, 'height' => 300]) }}" class="prof-c-j-francken-portrait rounded-circle" />
            </div>

            <h2 class="section-header mt-4 d-inline-block">
                About the association
            </h2>

            <p>
                <em>
                    T.F.V. ‘Professor Francken’ is the study association for Engineering Physics, connected to the University of Groningen.
                    It is named after Groningen’s first professor of Applied Physics and is for students and staff of the applied physics departments.
                </em>
            </p>

            <p>
                It has over 1100 members and organizes, among other, field trips in the Netherlands, an annual symposium and a foreign excursion.
                Various activities, including the introductory activities for first-year students, Expedition Strategy (a yearly event organised to introduce students to strategy consultancy in the Randstad), and the Beta Business Days (a career event for science students), are organised in partnership with brother associations.
                Membership is a must for physics students with a technical orientation.
            </p>

            @guest
            <div class="my-4">
                <h4 class="font-weight-bold">
                    Become a member
                </h4>
                <p>
                    A membership at our association costs only &euro;5,- per year and comes with many benefits such as free coffee and tea from our members room.
                    Each year we organise many study and career related activities such as practice sessions for your exams as well lectures and excursions to companies to help you be informed about future job opportunities.
                </p>

                <div class="mt-2">
                    <a href="/register" class="btn btn-secondary">Register</a>
                </div>
            </div>
            @endguest

            @if ($covid)
            <h3 class="font-weight-bold mt-5">
                <i class="fas fa-head-side-mask"></i>
                COVID-19 updates
                <br/>
            </h3>
            <p>
                Stay up to date with the latest RIVM and university measures, and precautions taken by the assocation.
            </p>
            <div class="d-flex align-items-center">
                <a class="btn btn-primary mr-3" href="{{ url($covid->slug) }}">Read the latest updates</a>
                <small class="text-muted h6">Last updated {{ $covid->updated_at->diffForHumans() }}</small>
            </div>
            @endif

        </div>
        <aside class="col-md-5 order-0 order-md-12 mt-n5">
            <div class="agenda-wrapper">
                @include("homepage._agenda")
            </div>
        </aside>
    </div>

    <div class="row">
        <div class="col text-right">
            <img alt="Preview of the latest Francken Vrij edition" src="/images/francken-vrij-homepage.png" class="img-fluid"/>
        </div>
        <div class="col-md-5">
            <h3 class="section-header">The latest Francken Vrij</h3>
            <p>
                Francken Vrij is the popular science magazine of the Technisch Fysische Vereniging ‘Professor Francken’ and is distributed to its members, sponsors and other interested parties.
                The magazine has a different theme every edition that in some way has a connection to engineering physics, and generally might contain the following:
            </p>

            <ul class="list list-unstyled">
                <li>A scientific article from one of the research groups</li>
                <li>A theoretical view of something pertaining to the theme</li>
                <li>The story of a member that did an internship or has started working</li>
                <li>A challenging puzzle</li>
            </ul>

            <p>
                Below you can download the <strong>latest edition</strong> of the Francken Vrij, or go to the archive including all published Francken Vrij magazines.
            </p>

            @isset($latest_edition)
            <a class="btn btn-primary" href="{{ $latest_edition->pdf() }}">
                Download latest edition
            </a>
            @endisset
            <a class="link-to-all-dark text-nowrap" href="/association/francken-vrij">
                Go to the archive
            </a>
        </div>
    </div>
<br>
   
</div>
