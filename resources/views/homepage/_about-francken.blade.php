@inject('franckenVrij', "Francken\Application\FranckenVrij\FranckenVrijRepository")
<div class="container">
    <div class="row">
        <div class="col about-francken">
            <div class="about-francken__j-c-francken">
                <img alt="" src="/images/prof-jan-carel-francken.png" class="prof-c-j-francken-portrait rounded-circle" />
            </div>

            <h2 class="section-header mt-4 d-inline-block">
                About the association
            </h2>

            <p>
                <em>
                    ‘Professor Francken’ is the study association for Applied Physics, connected to the University of Groningen.
                    It is named after Groningen’s first professor of Applied Physics and is for students and staff of the applied physics departments.
                </em>
            </p>
            <p>
                It has over 700 members and organizes, among other, field trips in the Netherlands and an annual symposium and a foreign excursion.
                Various activities, including the introductory activities for first-year students and the Bèta-bedrijvendagen (a career event for science students), are organised in partnership with sister associations.
                Membership is a must for students with a technical orientation.
            </p>

            <div class="text-right mt-4">
                <a href="/association" class="btn btn-primary">Read more</a>
            </div>
        </div>
        <aside class="col-md-5 flex-first flex-md-last">
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
            </p>

            <ul class="list list-unstyled">
                <li>Porta nibh venenatis cras sed.</li>
                <li>Lorem donec massa sapien, faucibus et.</li>
                <li>Id aliquet risus feugiat in ante metus?</li>
                <li>Sodales neque sodales ut.</li>
            </ul>

            <p>
                Below you can download the <strong>latest edition</strong> of the Francken Vrij, or go to the archive including all published Francken Vrij magazines.
            </p>

            <a class="btn btn-primary" href="{{ $franckenVrij->latestEdition()->pdf() }}">Download latest edition</a>
            <a class="link-to-all-dark text-nowrap" href="/association/francken-vrij">Go to the archive</a>
        </div>
    </div>
</div>
