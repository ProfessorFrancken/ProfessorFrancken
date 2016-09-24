@extends('pages.about.committees')

@push('css')
<style type="text/css">
 @font-face {
 font-family: pixels;
 src: url(/fonts/LLPIXEL3.ttf);
 }

 td {
     padding: 15px;
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

 .aligncenter {
     clear: both;
     display: block;
     margin: 0 auto;
 }

 .game-jam-title {
     font-family:pixels;
     color:#000000;
     font-size:50px;
     text-align:center
 }
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="game-jam-title">
                Francken Game Jam
            </h1>

            <h3 class="game-jam-title">
                <small>
                6,7 and 8 March 2015
                </small>
            </h3>
            <img alt="Franckenators" class="img-responsive aligncenter" height="360" src="http://www.professorfrancken.nl/wordpress/wp-content/uploads/2015/01/Franckenators.gif" width="720">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">

            <h2 class="game-jam-title">Information</h2>
            <p style="font-family:Gill sans;"><b>The Gamejam is over and it was awesome! Check out all created games under ‘Games’</b><br>
                <br>
                <i>Have you ever wondered how a videogame is made? Do you have an idea for a game you have not seen before? Do you want to design a cardgame that is more exciting than Texas-hold-‘m, works on your nerves like BlackJack, but is as intuitive to play as the two combined?</i><br>
                <br>
                Francken is organizing the Francken Game Jam, an event where teams compete (or cooperate) to design and realize a prototype of a boardgame or computer game that is original, exciting, addictive or just gorgeous to look at or listen to. All qualities can and will be used and everyone is welcome to focus all their creativity in one weekend. So if you can play an instrument, make electronic music, write program code, write stories, tell jokes, paint, draw, photoshop, use electronics to make your own controller or if you just have a brilliant idea for a game, assemble a divers team and subscribe for the game jam!<br>
                <br>
                Teams that want to make a videogame are strongly recommended to have at least one team member that has experience with a game-engine. If you do not have such a team member, do not despair! Francken will organize an introduction to Unity3D, a much used game engine for both 2D and 3D games. The introduction will be given by professional game developers from the Groningen company Indietopia. They will also be present at the jam itself for support and coaching. Programming experience is required for Unity3D. If you have no programming skills and still want to learn how to use a game-engine, we can provide you with other software that you can learn by yourself.<br>
                <br>
                More information on the Game Jam and on game-engines can be found at our wikipage: <a href="http://www.professorfrancken.nl/scriptcie/gamejam/">http://www.professorfrancken.nl/scriptcie/gamejam/</a>
            </p>
        </div>

        <div class="col-md-6">
            <h2 class="game-jam-title">Games</h2>
            <div class="gallery galleryid-4725 gallery-columns-3 gallery-size-thumbnail" id="gallery-1">
                <dl class="gallery-item">
                    <dt class="gallery-icon landscape">
                        <a href="http://www.professorfrancken.nl/gamejam/games/baas/"><img alt="Bazen game" class="attachment-thumbnail" height="150" src="http://www.professorfrancken.nl/wordpress/wp-content/uploads/2015/01/baas.jpg" width="150"></a>
                    </dt>
                </dl>
                <dl class="gallery-item">
                    <dt class="gallery-icon landscape">
                        <a href="http://www.professorfrancken.nl/gamejam/games/segwars/SegWars%20Web%20Build.html"><img alt="Bazen game" class="attachment-thumbnail" height="150" src="http://www.professorfrancken.nl/wordpress/wp-content/uploads/2015/01/segwars.jpg" width="150"></a>
                    </dt>
                </dl>
                <dl class="gallery-item">
                    <dt class="gallery-icon landscape">
                        <a href="http://www.professorfrancken.nl/gamejam/games/mammoettanker/mammoettanker.html"><img alt="Bazen game" class="attachment-thumbnail" height="150" src="http://www.professorfrancken.nl/wordpress/wp-content/uploads/2015/01/mammoettanker.jpg" width="150"></a>
                    </dt>
                </dl>
                <dl class="gallery-item">
                    <dt class="gallery-icon landscape">
                        <a href="http://www.professorfrancken.nl/gamejam/games/mastronaut/Webbuild.html"><img alt="Bazen game" class="attachment-thumbnail" height="150" src="http://www.professorfrancken.nl/wordpress/wp-content/uploads/2015/01/mastronaut.jpg" width="150"></a>
                    </dt>
                </dl>
                <dl class="gallery-item">
                    <dt class="gallery-icon landscape">
                        <a href="http://www.professorfrancken.nl/gamejam/games/ballen/webbuildfinal.html"><img alt="Bazen game" class="attachment-thumbnail" height="150" src="http://www.professorfrancken.nl/wordpress/wp-content/uploads/2015/01/ballen.jpg" width="150"></a>
                    </dt>
                </dl>
            </div>
            <h2 class="game-jam-title">Sponsors</h2>
            <div class="gallery galleryid-4725 gallery-columns-3 gallery-size-thumbnail" id="gallery-1">
                <dl class="gallery-item">
                    <dt class="gallery-icon landscape">
                        <a href="http://www.indietopia.org"><img alt="Indietopia" class="attachment-thumbnail" height="150" src="http://www.professorfrancken.nl/wordpress/wp-content/uploads/2015/01/small-150x150.png" width="150"></a>
                    </dt>
                </dl>
                <dl class="gallery-item">
                    <dt class="gallery-icon landscape">
                        <a href="http://www.unity3d.com"><img alt="Unity" class="attachment-thumbnail" height="150" src="http://www.professorfrancken.nl/wordpress/wp-content/uploads/2015/01/photo-150x150.png" width="150"></a>
                    </dt>
                </dl>
            </div>
        </div>
    </div>
@endsection
