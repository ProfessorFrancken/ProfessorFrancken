@extends('committees.show')

@push('css')
<style type="text/css">
.aligncenter {
    clear: both;
    display: block;
    margin: 0 auto;
}
#gallery-1 {
    margin: auto;
}
#gallery-1 .gallery-item {
    float: left;
    margin-top: 10px;
    text-align: center;
    width: 33%;
}
#gallery-1 img {
    border: 2px solid #cfcfcf;
}
#gallery-1 .gallery-caption {
    margin-left: 0;
}
/* see gallery_shortcode() in wp-includes/media.php */
.brouwcie-title {
    font-weight: 500;
    font-family:gebouw13;
    color:#000000;
 }
@font-face {
    font-family: gebouw13;
    src: url(/fonts/ModernSerifEroded.ttf);
}
.hover:hover{
    cursor:pointer;
}
p {
    font-family: "Gill Sans" ;
}

.table .success > td {
    background-color: #d9ffcc !important;
}
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="brouwcie-title text-center">
                Brouwcie - Gebouw 13
            </h1>
            <h2 class="brouwcie-title text-center">
                Francken brouwcommissie
            </h2>
            <img
                alt="Franckenators"
                class="img-fluid aligncenter"
                src="http://www.professorfrancken.nl/wordpress/wp-content/uploads/2015/01/Brouwcie.png"
                width="720"
            />
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h2 class="brouwcie-title">
                Informatie
            </h2>
            <p class="text-justify">
                De Brouwcie vond haar oorsprong in een groep op bier georiënteerde studenten van de TFV. Voeg bij het idee om eens zelf een biertje te brouwen bij een vleugje ‘gewoon gaan’ en het duurt niet lang voordat er een pruttelende ketel op het vuur staat. De Commissie is nu al toe aan zijn tweede en verbeterde brouwinstallatie en blijft stevig door automatiseren.
            </p>
            <p class="text-justify">
                Om het bier te beschrijven moet gezocht worden naar iets dat heeft geleid tot het ontstaan ervan. Graag geloven wij dat de studie technische natuurkunde een belangrijk deel heeft bijgedragen aan het beginnen van dit avontuur. Het is echter de locatie die ons allen bindt. Al sinds vele jaren is er een plek in Nijenborgh waar altijd koffie klaarstaat, er vele vierde mannen rondlopen en de koffie na vier uur vervangen wordt door bier. Dit alles een een gebouw met de sfeer waar niet elke kroeg aan kan tippen. Het bier van de Brouwcie is dan ook een ode aan deze mooie plaats. een ode aan de wetenschappers die er werken en een ode aan de studenten die er studeren. Het is een ode aan gebouw 13…
            </p>
        </div>
    </div>

    <hr/>

    @include('committees._members', ['members' => $committee->members ])
@endsection
