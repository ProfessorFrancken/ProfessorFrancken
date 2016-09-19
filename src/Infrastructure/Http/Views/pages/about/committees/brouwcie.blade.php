@extends('pages.about.committees')

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
@font-face {
    font-family: gebouw13;
    src: url(/fonts/ModernSerifEroded.ttf);
}
td {
    padding: 15px;
    text-align:justify;
}
h1 {
    font-family:gebouw13;
}
h2 {
    font-family:gebouw13;
}
.border_bottom td {
    border-bottom:1pt dotted black;
}
.hover:hover{
    cursor:pointer;
}
</style>
@endpush

@push('javascript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="http://www.borrelcie.vodka/includes/graph/Chart.js"></script>

    <script type="text/javascript">
     $.get("http://www.professorfrancken.nl/brouwcie2.php", function(streepdataWeek) {
         streepdataWeek = JSON.parse(streepdataWeek);

         var dagen = [];
         var totaalWeek = [];
         var aantal = streepdataWeek.length;
         for(var idx = 0; idx < aantal; ++idx)
             {
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

    <script type="text/javascript" src="http://wwww.professorfrancken.nl/scripts/brouwcie.js"></script>
@endpush

@section('content')
<div class="entry-main">
		<div class="entry-content">

            <h1 style="font-family:gebouw13; color:#000000; font-size:50px; text-align:center;">Brouwcie - Gebouw 13</h1>

            <h2 style="font-family:gebouw13; color:#000000; font-size:50px; text-align:center;">Francken brouwcommissie</h2>

            <p>
                <img src="http://www.professorfrancken.nl/wordpress/wp-content/uploads/2015/01/Brouwcie.png" alt="Franckenators" width="720" class="aligncenter size-large wp-image-4726">
            </p>

            <table style="color:#000000; font-size:16px; text-align:center;">
                <tbody><tr width="100%">
                    <td width="50%"><h2 style="font-size:50px; color:#000000;">Informatie</h2><p style="font-family:Gill sans;"></p><p>
                        De Brouwcie vond haar oorsprong in een groep op bier georiënteerde studenten van de TFV. Voeg bij het idee om eens zelf een biertje te brouwen bij een vleugje ‘gewoon gaan’ en het duurt niet lang voordat er een pruttelende ketel op het vuur staat. De Commissie is nu al toe aan zijn tweede en verbeterde brouwinstallatie en blijft stevig door automatiseren.</p>
                        <p>
                            Om het bier te beschrijven moet gezocht worden naar iets dat heeft geleid tot het ontstaan ervan. Graag geloven wij dat de studie technische natuurkunde een belangrijk deel heeft bijgedragen aan het beginnen van dit avontuur. Het is echter de locatie die ons allen bindt. Al sinds vele jaren is er een plek in Nijenborgh waar altijd koffie klaarstaat, er vele vierde mannen rondlopen en de koffie na vier uur vervangen wordt door bier. Dit alles een een gebouw met de sfeer waar niet elke kroeg aan kan tippen. Het bier van de Brouwcie is dan ook een ode aan deze mooie plaats. een ode aan de wetenschappers die er werken en een ode aan de studenten die er studeren. Het is een ode aan gebouw 13…</p>
                        <p></p></td>
                    <td width="50%"><h2 style="font-size:50px; color:#000000;">Consumptie</h2>
                        <div class="chartWrapper" style="">
                            <div class="chartAreaWrapper" style="width: 500px; overflow-x: scroll; direction:rtl;">
                                <div style="width: 6000px; height:300px overflow:hidden;">
                                    <canvas id="canvas" width="7500" height="375" style="width: 6000px; height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr width="100%">
                    <td width="50%"><h2 style="font-size:50px; color:#000000;">Bieren in de maak</h2><p>
                    </p><table id="brouwtable"><tbody><tr class="border_bottom"><th>Type bier</th><th>Verwachte leverdatum</th><th>Hoeveelheid (liter)</th></tr><tr class="border_bottom" style="background-color:#d9ffcc;"><td>Weizen</td><td>2016-07-08 (geleverd)</td><td>40 liter</td></tr><tr class="border_bottom" style="background-color:#d9ffcc;"><td>Weizen</td><td>2016-06-24 (geleverd)</td><td>40 liter</td></tr><tr class="border_bottom" style="background-color:#d9ffcc;"><td>Blonde</td><td>2016-02-01 (geleverd)</td><td>30 liter</td></tr><tr class="border_bottom" style="background-color:#d9ffcc;"><td>Blonde</td><td>2016-01-25 (geleverd)</td><td>10 liter</td></tr><tr class="border_bottom" style="background-color:#d9ffcc;"><td>Blonde</td><td>2016-01-18 (geleverd)</td><td>20 liter</td></tr></tbody></table>
                    <p></p></td>
                    <td width="50%"><h2 style="font-size:50px; color:#000000;">Bieren</h2><p>
                    </p><div id="gallery-1" class="gallery galleryid-4725 gallery-columns-3 gallery-size-thumbnail">
                        <dl class="gallery-item">
                            <dt class="gallery-icon landscape">
                                <p onclick="change_bier(1)" class="hover"><img id="bierimg1" width="150" height="150" src="http://www.professorfrancken.nl/wordpress/wp-content/uploads/2015/11/bier1.jpg" class="attachment-thumbnail" alt="Grand cru"></p>
                            </dt></dl>
                        <dl class="gallery-item">
                            <dt class="gallery-icon landscape">
                                <p onclick="change_bier(2)" class="hover"><img id="bierimg2" width="150" height="150" src="http://www.professorfrancken.nl/wordpress/wp-content/uploads/2015/11/bier2.jpg" class="attachment-thumbnail" alt="Grand cru"></p>
                            </dt></dl>
                        <dl class="gallery-item">
                            <dt class="gallery-icon landscape">
                                <p onclick="change_bier(3)" class="hover"><img id="bierimg3" width="150" height="150" src="http://www.professorfrancken.nl/wordpress/wp-content/uploads/2015/11/bier3.jpg" class="attachment-thumbnail" alt="Grand cru"></p></dt></dl>
                        <br style="clear: both">
                    </div>
                    <p></p></td>


                </tr>
                <tr width="100%">
                    <td width="50%">
                        <h2 style="font-size:50px; color:#000000;">Contact</h2>
                        <form method="post" id="cntctfrm_contact_form" action="http://www.professorfrancken.nl/wordpress/vereniging/commissies/brouwcie/#cntctfrm_contact_form" enctype="multipart/form-data"><div style="text-align: left; padding-top: 5px;">
						                <label for="cntctfrm_contact_name">Naam: <span class="required">*</span></label>
					              </div><div style="text-align: left;">
						                <input class="text" type="text" size="40" value="" name="cntctfrm_contact_name" id="cntctfrm_contact_name" style="text-align: left; margin: 0;">
					              </div><div style="text-align: left;">
					                  <label for="cntctfrm_contact_email">Email adres: <span class="required">*</span></label>
				                </div><div style="text-align: left;">
					                  <input class="text" type="text" size="40" value="" name="cntctfrm_contact_email" id="cntctfrm_contact_email" style="text-align: left; margin: 0;">
				                </div>
			                  <div style="text-align: left;">
					                  <label for="cntctfrm_contact_subject">Onderwerp: <span class="required">*</span></label>
				                </div><div style="text-align: left;">
					                  <input class="text" type="text" size="40" value="" name="cntctfrm_contact_subject" id="cntctfrm_contact_subject" style="text-align: left; margin: 0;">
				                </div>

				                <div style="text-align: left;">
					                  <label for="cntctfrm_contact_message">Bericht: <span class="required">*</span></label>
				                </div><div style="text-align: left;">
					                  <textarea rows="5" cols="30" name="cntctfrm_contact_message" id="cntctfrm_contact_message"></textarea>
				                </div><div style="text-align: left; padding-top: 8px;"><input type="hidden" value="send" name="cntctfrm_contact_action"><input type="hidden" value="Version: 3.30">
					                  <input type="hidden" value="en" name="cntctfrm_language">
					                  <input type="submit" value="Versturen" style="cursor: pointer; margin: 0pt; text-align: center;margin-bottom:10px;">
				                </div>
				                </form>
                    </td>
                    <td width="50%" id="bierinformatie" style="display:none;"><h2 style="font-size:50px; color:#000000;" id="biertitel">Weizen</h2>
                        <p style="display:none;" id="bier1">Grand cru - De grand cru was het eerste bier gefabriceerd door de Brouwers van de TFV. Het was een test, om te kijken of de apparatuur wel in staat was om goed bier te produceren. Van de brouwers stond dit uiteraard al buiten kijf. <br><br>

                            Een grand Cru is een vrij ruime categorie bieren. Het impliceer voornamelijk een hoge kwaliteit. Uiteraard perfect als eerste brouwsel. De ingrediënten variëren van slechts mout hop en gist, tot exotische toevoegingen als sinaasappelschil en kaneel. Voornaamste eigenschap van dit specifieke geval is dat het in een handige knor-wereldgerecht achtige bereiding. Dit stelde de Brouwers in staat om alle facturen buiten de apperatuur te minimaliseren. Als het bier zonder zure smaak uit de fles zou komen zou dat wijzen op goede controle over de apperatuur. <br><br>

                            Het resultaat is een heerlijk zoet biertje en een hard onder de riem van de brouwers van de TFV. Het hek is van de dam!</p>
                        <p style="display:none;" id="bier2">Weizen - De weissen werd gebrouwen voor het snelle resultaat. Weissen hoeft namelijk maar kort te gisten en dat maakt het een goed bier als je snel je eigen bier wil drinken, wat gek genoeg het geval was.<br><br>

                            Weissen is van oorsprong een zuid-Duits of beirisch bier, dat voor meer dan de helft bestaat uit tarwemout. De tarwe in het witbier wordt niet gemout, waaraan het zijn eigenaardige karakter ontleent, en wat het minder vergistbaar maakt. Daarnaast produceren de speciale gisten die gebruikt worden fruitige en kruidige smaken. Ook valt op dat in Weissen, minder hop gebruikt wordt, wat het bier minder bitter maakt.<br><br>

                            Om onze eigen draai aan de Weissentraditie te geven, hebben wij gekozen voor een ‘geuzen-weissen’. De zurige smaak geeft een unieke beleving aan het eerste compleet zelf gecreëerde biertje.</p>
                        <p style="display:none;" id="bier3">Blonde - Het gebouw 13 blondbier is het eerste bier dat gebruik maakte van de nieuwe opgeschaalde instalatie van de brouwcie. Het idee achter het blondbier, is het presenteren van een drinkbaar biertje voor iedereen, dat toch een speciaal karakter heeft.<br><br>

                            Het Gebouw 13 blondbier is een bier dat is gebrouwen uit een mengsel van alemout en pilschmout met een bijzonder milde hop. De toevoeging van minder goed vergistbare suikers levert een biertje dat zowel door onze op ‘reinheid’ kickende oosterburen en de wat bourgondischere belgen gewaardeerd zal worden.<br><br>

                            Het blondbier heeft vele variaties in ingrediënten doorlopen en dat is geconvergeerd naar een vol biertje wat met zijn zoetige smaak, het alcoholgehalte wat maskeert. Dus moeders houdt uw dochters binnen, het blondbier is echt een gebouw!</p>
                    </td></tr>
                </tbody>
            </table>
		</div><!-- .entry-content -->
</div>
@endsection
