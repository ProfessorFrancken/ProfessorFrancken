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

@push('javascript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="http://www.borrelcie.vodka/includes/graph/Chart.js"></script>

    <script type="text/javascript">
     // This isn't working currently due to Access-Control-Allow-Origin errors
     $.get("http://www.professorfrancken.nl/brouwcie2.php", function(streepdataWeek) {
         streepdataWeek = JSON.parse(streepdataWeek);

         var dagen = [];
         var totaalWeek = [];
         var aantal = streepdataWeek.length;
         for(var idx = 0; idx < aantal; ++idx) {
             totaalWeek[idx] = streepdataWeek[aantal-1 - idx][1];
             dagen[idx] = streepdataWeek[aantal-1 - idx][0];
         }

         var barChartData = {
             labels : dagen,
             datasets : [
                 {
                     label: "Brouwcie shit",
                     fillColor : "rgba(38,34,97,0.2)",
                     strokeColor : "rgba(38,34,97,1)",
                     pointColor : "rgba(38,34,97,1)",
                     pointStrokeColor : "#fff",
                     pointHighlightFill : "#fff",
                     pointHighlightStroke : "rgba(220,220,220,1)",
                     data : totaalWeek
                 }
             ]

         }
         var ctx = document.getElementById("canvas").getContext("2d");
         window.myBar = new Chart(ctx).Line(barChartData, {
             responsive : true,
             scaleBeginAtZero: true
         });
     });
    </script>

    <script>
     biertitels = ["test1", "Grand Cru", "Weizen", "Blonde"];
     bierinhoudid = ["", "bier1", "bier2", "bier3"];

     function change_bier(bierid){
         if (bierid <= 0 || bierid > 3) {
			       document.getElementById('bierinformatie').style.display = 'none';
             return;
         }

			   for(i=1;i<=3;i++){
				     if(i==bierid){
					       document.getElementById('biertitel').innerHTML = biertitels[bierid];
					       document.getElementById(bierinhoudid[i]).style.display = '';
					       document.getElementById('bierinformatie').style.display = '';
					       document.getElementById("bierimg"+i).src = "http://www.professorfrancken.nl/wordpress/wp-content/uploads/2015/11/bier"+i+"s.jpg";
				     }else{
					       document.getElementById(bierinhoudid[i]).style.display = 'none';
					       document.getElementById("bierimg"+i).src = "http://www.professorfrancken.nl/wordpress/wp-content/uploads/2015/11/bier"+i+".jpg";
				     }
			   }
     }

     // This isn't working currently due to Access-Control-Allow-Origin errors
     var xmlhttp = new XMLHttpRequest();
     var url = "http://www.professorfrancken.nl/scripts/ical_ophalen.php";

     xmlhttp.onreadystatechange = function() {
         if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
             var myArr = JSON.parse(xmlhttp.responseText);
             gaan(myArr);
         }
     };
     xmlhttp.open("GET", url, true);
     xmlhttp.send();

     function gaan(data){
	       var str = "<tr class='border_bottom'><th>Type bier</th><th>Verwachte leverdatum</th><th>Hoeveelheid (liter)</th></tr>";

         console.log('heeuj');
		     var tel = 0;
			   for(var idx in data) {
				     if(tel<5){
					       if(data[idx].geleverd==1){
						         str += "<tr class='border_bottom' style='background-color:#d9ffcc;'>";
						         str += "<td>"+biertitels[data[idx].type]+"</td>";
						         str += "<td>"+data[idx].timestamp+" (geleverd)</td>";
						         str += "<td>"+data[idx].liters+" liter</td>";
						         str += "</tr>";
					       }else{
						         str += "<tr class='border_bottom'>";
						         str += "<td>"+biertitels[data[idx].type]+"</td>";
						         str += "<td>"+data[idx].timestamp+"</td>";
						         str += "<td>"+data[idx].liters+" liter</td>";
						         str += "</tr>";

					       }
					       tel = tel+1;
				     }
			   }
			   $("#brouwtable").html(str);

     }
    </script>
@endpush


@section('contact-form')
<h2 class="brouwcie-title">Contact</h2>
    <form action= "http://www.professorfrancken.nl/wordpress/vereniging/commissies/brouwcie/#cntctfrm_contact_form" enctype="multipart/form-data" id="cntctfrm_contact_form" method="post" name="cntctfrm_contact_form">

        <div class="form-group">
            <label for="cntctfrm_contact_name">Naam: <span class= "required">*</span> </label>
            <input class="form-control text" id="cntctfrm_contact_name" name= "cntctfrm_contact_name" type="text" value="" required>
        </div>

        <div class="form-group">
            <label for="cntctfrm_contact_email">Email adres: <span class= "required">*</span></label>
            <input class="text form-control" id="cntctfrm_contact_email" name="cntctfrm_contact_email" type="text" value="" required>
        </div>

        <div class="form-group">
            <label for="cntctfrm_contact_subject">Onderwerp: <span class= "required">*</span></label>
            <input class="text form-control" id="cntctfrm_contact_subject" name="cntctfrm_contact_subject" type="text" value="" required>
        </div>

        <div class="form-group">
            <label for="cntctfrm_contact_message">Bericht: <span class="required">*</span></label>
            <textarea class="form-control" cols="30" id="cntctfrm_contact_message" name="cntctfrm_contact_message" rows="5" required></textarea>
        </div>

        <div style="text-align: left; padding-top: 8px;">
            <input name="cntctfrm_contact_action" type="hidden" value="send">
            <input type="hidden" value="Version: 3.30">
            <input name="cntctfrm_language" type="hidden" value="en">
            <button type="submit" class="btn btn-default">Versturen</button>
        </div>
    </form>
@endsection

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
        <div class="col-md-12">
            <h2 class="brouwcie-title">
                Consumptie
            </h2>
            <div class="chartWrapper" style="">
                <div class="chartAreaWrapper" style="width: 500px; overflow-x: scroll; direction:rtl;">
                    <div style="width: 6000px; height:300px overflow:hidden;">
                        <canvas height="375" id="canvas" style="width: 6000px; height: 300px;" width= "7500"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h2 class="brouwcie-title">
                Bieren in de maak
            </h2>
            <table id="brouwtable" class="table">
                <tbody>
                    <tr class="border_bottom">
                        <th>Type bier</th>
                        <th>Verwachte leverdatum</th>
                        <th>Hoeveelheid (liter)</th>
                    </tr>
                    <tr class="success">
                        <td>Weizen</td>
                        <td>2016-07-08 (geleverd)</td>
                        <td>40 liter</td>
                    </tr>
                    <tr class="success">
                        <td>Weizen</td>
                        <td>2016-06-24 (geleverd)</td>
                        <td>40 liter</td>
                    </tr>
                    <tr class="success">
                        <td>Blonde</td>
                        <td>2016-02-01 (geleverd)</td>
                        <td>30 liter</td>
                    </tr>
                    <tr class="success">
                        <td>Blonde</td>
                        <td>2016-01-25 (geleverd)</td>
                        <td>10 liter</td>
                    </tr>
                    <tr class="success">
                        <td>Blonde</td>
                        <td>2016-01-18 (geleverd)</td>
                        <td>20 liter</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-12">
            <h2 class="brouwcie-title">
                Bieren
            </h2>
            <div class="gallery galleryid-4725 gallery-columns-3 gallery-size-thumbnail" id="gallery-1">
                <div class="row">
                    <div class="col-md-4">
                        <img alt="Grand cru" class="hover img-rounded img-responsive" id="bierimg1" src="http://www.professorfrancken.nl/wordpress/wp-content/uploads/2015/11/bier1.jpg" onclick="change_bier(1)">
                    </div>

                    <div class="col-md-4">
                        <img alt="Grand cru" class="hover img-rounded img-responsive" id="bierimg2" src="http://www.professorfrancken.nl/wordpress/wp-content/uploads/2015/11/bier2.jpg" onclick="change_bier(2)">
                    </div>
                    <div class="col-md-4">
                        <img alt="Grand cru" class="hover img-rounded img-responsive" id="bierimg3" src="http://www.professorfrancken.nl/wordpress/wp-content/uploads/2015/11/bier3.jpg" onclick="change_bier(3)">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-push-6">
            <div id="bierinformatie" style="display:none">
                <h2 class="brouwcie-title" id="biertitel">Weizen</h2>
                <p id="bier1" style="display:none;" class="text-justify">
                    Grand cru - De grand cru was het eerste bier gefabriceerd door de Brouwers van de TFV. Het was een test, om te kijken of de apparatuur wel in staat was om goed bier te produceren. Van de brouwers stond dit uiteraard al buiten kijf.<br>
                    <br>
                    Een grand Cru is een vrij ruime categorie bieren. Het impliceer voornamelijk een hoge kwaliteit. Uiteraard perfect als eerste brouwsel. De ingrediënten variëren van slechts mout hop en gist, tot exotische toevoegingen als sinaasappelschil en kaneel. Voornaamste eigenschap van dit specifieke geval is dat het in een handige knor-wereldgerecht achtige bereiding. Dit stelde de Brouwers in staat om alle facturen buiten de apperatuur te minimaliseren. Als het bier zonder zure smaak uit de fles zou komen zou dat wijzen op goede controle over de apperatuur.<br>
                    <br>
                    Het resultaat is een heerlijk zoet biertje en een hard onder de riem van de brouwers van de TFV. Het hek is van de dam!
                </p>
                <p id="bier2" style="display:none;" class="text-justify">
                    Weizen - De weissen werd gebrouwen voor het snelle resultaat. Weissen hoeft namelijk maar kort te gisten en dat maakt het een goed bier als je snel je eigen bier wil drinken, wat gek genoeg het geval was.<br>
                    <br>
                    Weissen is van oorsprong een zuid-Duits of beirisch bier, dat voor meer dan de helft bestaat uit tarwemout. De tarwe in het witbier wordt niet gemout, waaraan het zijn eigenaardige karakter ontleent, en wat het minder vergistbaar maakt. Daarnaast produceren de speciale gisten die gebruikt worden fruitige en kruidige smaken. Ook valt op dat in Weissen, minder hop gebruikt wordt, wat het bier minder bitter maakt.<br>
                    <br>
                    Om onze eigen draai aan de Weissentraditie te geven, hebben wij gekozen voor een ‘geuzen-weissen’. De zurige smaak geeft een unieke beleving aan het eerste compleet zelf gecreëerde biertje.
                </p>
                <p id="bier3" style="display:none;" class="text-justify">
                    Blonde - Het gebouw 13 blondbier is het eerste bier dat gebruik maakte van de nieuwe opgeschaalde instalatie van de brouwcie. Het idee achter het blondbier, is het presenteren van een drinkbaar biertje voor iedereen, dat toch een speciaal karakter heeft.<br>
                    <br>
                    Het Gebouw 13 blondbier is een bier dat is gebrouwen uit een mengsel van alemout en pilschmout met een bijzonder milde hop. De toevoeging van minder goed vergistbare suikers levert een biertje dat zowel door onze op ‘reinheid’ kickende oosterburen en de wat bourgondischere belgen gewaardeerd zal worden.<br>
                    <br>
                    Het blondbier heeft vele variaties in ingrediënten doorlopen en dat is geconvergeerd naar een vol biertje wat met zijn zoetige smaak, het alcoholgehalte wat maskeert. Dus moeders houdt uw dochters binnen, het blondbier is echt een gebouw!
                </p>
            </div>
        </div>

        <div class="col-md-12">
            @yield('contact-form')
        </div>
    </div>

    <hr/>

    @include('committees._members', ['members' => array_first($committee['years']) ])
@endsection
