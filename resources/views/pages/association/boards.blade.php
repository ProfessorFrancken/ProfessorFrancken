@extends('pages.association')

@section('content')

  <h1 class="centered-header">
    Boards
  </h1>

  <div class="row">
    <div class="col-sm-9">

      <hr>

      @include("pages.association._board", ['board' => [
        'year' => '2016-2017',
        'name' => 'Buitengewoon',
        'members' => [
          ['name' => 'Anton Jansen', 'title' => 'Chairman'],
          ['name' => 'Willeke Mulder', 'title' => 'Secretary and Commissioner of Education'],
          ['name' => 'David Koning', 'title' => 'Treasurer'],
          ['name' => 'Anne in ‘t Veld', 'title' => 'Commissioner of External Relations and Vice-Chairman']
        ],
        'figure' => 'http://www.professorfrancken.nl/wordpress/media/images/besturen/bestuur_1617.jpg'
      ]])

      <hr>

      @include("pages.association._board", ['board' => [
        'year' => '2015-2016',
        'name' => 'Daadkracht',
        'members' => [
          ['name' => 'Jelle Bor', 'title' => 'Chairman'],
          ['name' => 'Max Kamperman', 'title' => 'Secretary and Commissioner of Education'],
          ['name' => 'Evelien Zwanenburg', 'title' => 'Treasurer'],
          ['name' => 'Pieter Wolff', 'title' => 'Commissioner of External Relations and Vice-Chairman']
        ],
        'figure' => 'http://www.professorfrancken.nl/wordpress/media/images/besturen/bestuur_1516.JPG'
      ]])

      <hr>

      @include("pages.association._board", ['board' => [
        'year' => '2014-2015',
        'name' => 'Ingenieus',
        'members' => [
          ['name' => 'Hilbert van Loo', 'title' => 'Chairman'],
          ['name' => 'Serte Donderwinkel', 'title' => 'Secretary and Vice-Chairman'],
          ['name' => 'Steven Groen', 'title' => 'Treasurer'],
          ['name' => 'Friso Wobben', 'title' => 'Commissioner of External Relations']
        ],
        'figure' => 'http://www.professorfrancken.nl/wordpress/media/images/besturen/bestuur_1415.JPG'
      ]])



      <hr>

    </div>

    <div class="col-sm-3" style="font-size: 14px">
      <ul class="nav">
        <li><a href="#2016">Buitengewoon (2016-2017)</a></li>
        <li><a href="#2015">Daadkracht (2015-2016)</a></li>
        <li><a href="#2014">Ingenieus (2014-2015)</a></li>
        <li><a href="#2013">Aantrekkingskracht (2013-2014)</a></li>
        <li><a href="#2012">Binnenstebuiten (2012-2013)</a></li>
        <li><a href="#2011">Vooruit (2011-2012)</a></li>
        <li><a href="#2010">Ruimte (2010-2011)</a></li>
        <li><a href="#2009">Romeo Delta (2009-2010)</a></li>
        <li><a href="#2008">Surreëel (2008-2009)</a></li>
        <li><a href="#2007">Smakeloos (2007-2008)</a></li>
        <li><a href="#2006">Vanzulf (2006-2007)</a></li>
      </ul>
    </div>
  </div>

@endsection
