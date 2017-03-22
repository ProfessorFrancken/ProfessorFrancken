@extends('pages.association')

@section('content')

  <h1 class="centered-header">
    Boards
  </h1>

      @include("pages.association._board", ['board' => [
        'year' => '2016-2017',
        'name' => 'Buitengewoon',
        'members' => [
          ['name' => 'Anton Jansen', 'title' => 'Chair'],
          ['name' => 'Willeke Mulder', 'title' => 'Secretary and Commissioner of Education'],
          ['name' => 'David Koning', 'title' => 'Treasurer'],
          ['name' => 'Anne in ‘t Veld', 'title' => 'Commissioner of External Relations and Vice-Chair']
        ],
        'figure' => 'http://www.professorfrancken.nl/wordpress/media/images/besturen/bestuur_1617.jpg'
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '2015-2016',
        'name' => 'Daadkracht',
        'members' => [
          ['name' => 'Jelle Bor', 'title' => 'Chair'],
          ['name' => 'Max Kamperman', 'title' => 'Secretary and Commissioner of Education'],
          ['name' => 'Evelien Zwanenburg', 'title' => 'Treasurer'],
          ['name' => 'Pieter Wolff', 'title' => 'Commissioner of External Relations and Vice-Chair']
        ],
        'figure' => 'http://www.professorfrancken.nl/wordpress/media/images/besturen/bestuur_1516.JPG'
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '2014-2015',
        'name' => 'Ingenieus',
        'members' => [
          ['name' => 'Hilbert van Loo', 'title' => 'Chair'],
          ['name' => 'Serte Donderwinkel', 'title' => 'Secretary and Vice-Chair'],
          ['name' => 'Steven Groen', 'title' => 'Treasurer'],
          ['name' => 'Friso Wobben', 'title' => 'Commissioner of External Relations']
        ],
        'figure' => 'http://www.professorfrancken.nl/wordpress/media/images/besturen/bestuur1415.jpg'
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '2013-2014',
        'name' => 'Aantrekkingskracht',
        'members' => [
          ['name' => 'Paul Wijnbergen', 'title' => 'Chair'],
          ['name' => 'Janna de Wit', 'title' => 'Secretary'],
          ['name' => 'Janneke Janssens', 'title' => 'Treasurer'],
          ['name' => 'Joran Böhmer', 'title' => 'Commissioner of External Relations and Vice-Chair']
        ],
        'figure' => 'http://www.professorfrancken.nl/wordpress/media/images/besturen/bestuur_1314_600breed.jpg'
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '2012-2013',
        'name' => 'Binnenstebuiten',
        'members' => [
          ['name' => 'Tom Bosma', 'title' => 'Chair'],
          ['name' => 'Guus Winter', 'title' => 'Secretary'],
          ['name' => 'Sjoerd Meesters', 'title' => 'Treasurer'],
          ['name' => 'Bauke Steensma', 'title' => 'Commissioner of External Relations and Vice-Chair']
        ],
        'figure' => 'http://www.professorfrancken.nl/wordpress/media/images/besturen/bestuur_1213_600breed.jpg'
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '2011-2012',
        'name' => 'Vooruit',
        'members' => [
          ['name' => 'Edwin de Jong', 'title' => 'Chair'],
          ['name' => 'Maurits de Jong', 'title' => 'Secretary'],
          ['name' => 'Marion Dam', 'title' => 'Treasurer'],
          ['name' => 'Tobias Van Damme', 'title' => 'Commissioner of External Relations and Vice-Chair']
        ],
        'figure' => 'http://www.professorfrancken.nl/wordpress/media/images/besturen/bestuur_1112_600breed.png'
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '2010-2011',
        'name' => 'Ruimte',
        'members' => [
          ['name' => 'Jasper Bosch', 'title' => 'Chair'],
          ['name' => 'Marten Hutten', 'title' => 'Secretary'],
          ['name' => 'Sjoerd Bielleman', 'title' => 'Treasurer'],
          ['name' => 'Hilbert Dijkstra', 'title' => 'Commissioner of External Relations and Vice-Chair']
        ],
        'figure' => 'http://www.professorfrancken.nl/wordpress/media/images/besturen/bestuur_1011_600breed.png'
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '2009-2010',
        'name' => 'Romeo Delta',
        'members' => [
          ['name' => 'Arjan Bijlsma', 'title' => 'Chair'],
          ['name' => 'Arjan Boerma', 'title' => 'Secretary'],
          ['name' => 'Aernout van der Poel', 'title' => 'Treasurer'],
          ['name' => 'Ypke Jager', 'title' => 'Commissioner of External Relations and Vice-Chair']
        ],
        'figure' => 'http://www.professorfrancken.nl/wordpress/media/images/besturen/bestuur_0910_600breed.jpg'
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '2008-2009',
        'name' => 'Surreëel',
        'members' => [
          ['name' => 'Mannold van der Schootbrugge', 'title' => 'Chair'],
          ['name' => 'Thijs Huijskes', 'title' => 'Secretary'],
          ['name' => 'Victor Haverkort', 'title' => 'Treasurer'],
          ['name' => 'Olger Zwier', 'title' => 'Commissioner of External Relations and Vice-Chair']
        ],
        'figure' => 'http://www.professorfrancken.nl/wordpress/media/images/besturen/bestuur_0809_600hoog.jpg'
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '2007-2008',
        'name' => 'Smakeloos',
        'members' => [
          ['name' => 'Mark Schenkel', 'title' => 'Chair'],
          ['name' => 'Laurens-Jan Soer', 'title' => 'Secretary'],
          ['name' => 'Pelle Koeslag', 'title' => 'Treasurer'],
          ['name' => 'Jakko de Jong', 'title' => 'Commissioner of External Relations and Vice-Chair']
        ],
        'figure' => 'http://www.professorfrancken.nl/wordpress/media/images/besturen/bestuur_0708_600breed.jpg'
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '2006-2007',
        'name' => 'Vanzulf',
        'members' => [
          ['name' => 'Rudy Schuitema', 'title' => 'Chair'],
          ['name' => 'Sander Boonstra', 'title' => 'Secretary'],
          ['name' => 'Jasper van den Berg', 'title' => 'Treasurer'],
          ['name' => 'Tom de Boer', 'title' => 'Commissioner of External Relations and Vice-Chair']
        ],
        'figure' => 'http://www.professorfrancken.nl/wordpress/media/images/besturen/bestuur_0607_600breed.jpg'
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '2005-2006',
        'name' => '',
        'members' => [
          ['name' => 'Christiaan van der Kwaak', 'title' => 'Chair'],
          ['name' => 'Wendy Docters', 'title' => 'Secretary'],
          ['name' => 'Reeuwerd Straatman', 'title' => 'Treasurer'],
          ['name' => 'Tom Boot', 'title' => 'Commissioner of External Relations and Vice-Chair']
        ],
        'figure' => 'http://www.professorfrancken.nl/wordpress/media/images/besturen/bestuur_0506_600breed.jpg'
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '2004-2005',
        'name' => '',
        'members' => [
          ['name' => 'Gerbert Bakker', 'title' => 'Chair'],
          ['name' => 'Bas Vlaming', 'title' => 'Secretary'],
          ['name' => 'Arjan van der Pal', 'title' => 'Treasurer'],
          ['name' => 'Sander Onur', 'title' => 'Commissioner of External Relations and Vice-Chair']
        ],
        'figure' => 'http://www.professorfrancken.nl/wordpress/media/images/besturen/bestuur_0405_600breed.jpg'
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '2003-2004',
        'name' => '',
        'members' => [
          ['name' => 'Marc de Boer', 'title' => 'Chair'],
          ['name' => 'Maaike Wiltjer', 'title' => 'Secretary'],
          ['name' => 'Teun Koeman', 'title' => 'Treasurer'],
          ['name' => 'Hedde van Hoorn', 'title' => 'Commissioner of External Relations and Vice-Chair']
        ],
        'figure' => 'http://www.professorfrancken.nl/wordpress/media/images/besturen/bestuur_0304_640breed.jpg'
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '2002-2003',
        'name' => '',
        'members' => [
          ['name' => 'Marten Frantzen', 'title' => 'Chair'],
          ['name' => 'Dennis Westra', 'title' => 'Secretary'],
          ['name' => 'Timon Lely', 'title' => 'Treasurer'],
          ['name' => 'Auke-Siûk Nutma', 'title' => 'Commissioner of External Relations and Vice-Chair']
        ],
        'figure' => 'http://www.professorfrancken.nl/wordpress/media/images/besturen/bestuur_0203_600breed.jpg'
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '2001-2002',
        'name' => '',
        'members' => [
          ['name' => 'Marloes Steneker', 'title' => 'Chair'],
          ['name' => 'Herman Nicolai', 'title' => 'Secretary'],
          ['name' => 'Peter Koopmans', 'title' => 'Treasurer'],
          ['name' => 'Reinier Kaptein', 'title' => 'Commissioner of External Relations and Vice-Chair']
        ],
        'figure' => ''
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '2000-2001',
        'name' => '',
        'members' => [
          ['name' => 'Chris Rademakers', 'title' => 'Chair and Treasurer'],
          ['name' => 'Tasco Silva', 'title' => 'Secretary'],
          ['name' => 'Erik Koop', 'title' => 'Commissioner of External Relations and Vice-Chair']
        ],
        'figure' => 'http://www.professorfrancken.nl/wordpress/media/images/besturen/bestuur_0001_600breed.jpg'
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '1999-2000',
        'name' => '',
        'members' => [
          ['name' => 'Ramon van Ingen', 'title' => 'Chair'],
          ['name' => 'Dirk Bekke', 'title' => 'Secretary'],
          ['name' => 'Wouter van Strien', 'title' => 'Treasurer'],
          ['name' => 'Laurens Willem van Beveren', 'title' => 'Commissioner of External Relations and Vice-Chair']
        ],
        'figure' => ''
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '1998-1999',
        'name' => '',
        'members' => [
          ['name' => 'Sander Nijman', 'title' => 'Chair'],
          ['name' => 'Wouter Soer', 'title' => 'Secretary'],
          ['name' => 'Jur de Vries', 'title' => 'Treasurer'],
          ['name' => 'Armand van der Veen', 'title' => 'Commissioner of External Relations and Vice-Chair']
        ],
        'figure' => ''
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '1997-1998',
        'name' => '',
        'members' => [
          ['name' => 'Frank Meijer', 'title' => 'Chair'],
          ['name' => 'Rutger van Merkerk', 'title' => 'Secretary'],
          ['name' => 'Victor van Heeswijk', 'title' => 'Treasurer'],
          ['name' => 'Ronald Hanson', 'title' => 'Commissioner of External Relations and Vice-Chair']
        ],
        'figure' => ''
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '1996-1997',
        'name' => '',
        'members' => [
          ['name' => 'Sjoerd Blom', 'title' => 'Chair'],
          ['name' => 'Jan-Willem Berghuis', 'title' => 'Secretary'],
          ['name' => 'Eric van de Schoot', 'title' => 'Treasurer'],
          ['name' => 'Bouke Hoving', 'title' => 'Commissioner of External Relations and Vice-Chair']
        ],
        'figure' => ''
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '1995-1996',
        'name' => '',
        'members' => [
          ['name' => 'Maarten Stokhof', 'title' => 'Chair'],
          ['name' => 'Lars de Groot', 'title' => 'Secretary'],
          ['name' => 'Jeroen de Boer', 'title' => 'Treasurer'],
          ['name' => 'Frederick Meis', 'title' => 'Commissioner of External Relations and Vice-Chair'],
          ['name' => 'Marc Gotink', 'title' => 'Commissioner of External Relations and Vice-Chair']],
        'figure' => ''
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '1994-1995',
        'name' => '',
        'members' => [
          ['name' => 'Frans Venker', 'title' => 'Chair'],
          ['name' => 'Walter Ganzevles', 'title' => 'Secretary'],
          ['name' => 'Marieke Duijvestein', 'title' => 'Treasurer'],
          ['name' => 'Robert-Jan Zandvoort', 'title' => 'Commissioner of External Relations and Vice-Chair']],
        'figure' => ''
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '1993-1994',
        'name' => '',
        'members' => [
          ['name' => 'Marlien Klijnstra', 'title' => 'Chair'],
          ['name' => 'Alex Schoonveld', 'title' => 'Secretary'],
          ['name' => 'Klaas Jan Wieringa', 'title' => 'Treasurer']],
        'figure' => ''
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '1992-1993',
        'name' => '',
        'members' => [
          ['name' => 'Sander Tichelaar', 'title' => 'Chair'],
          ['name' => 'Marco Workel', 'title' => 'Secretary'],
          ['name' => 'Robin Advokaat', 'title' => 'Treasurer']],
        'figure' => ''
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '1991-1992',
        'name' => '',
        'members' => [
          ['name' => 'Jorgen van der Velde', 'title' => 'Chair'],
          ['name' => 'Ruerd Heeg', 'title' => 'Secretary'],
          ['name' => 'Maarten van Essen', 'title' => 'Treasurer']],
        'figure' => ''
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '1990-1991',
        'name' => '',
        'members' => [
          ['name' => 'Arjan Douwes', 'title' => 'Chair'],
          ['name' => 'Nico van der Post', 'title' => 'Secretary'],
          ['name' => 'Peter Magnee', 'title' => 'Treasurer']],
        'figure' => ''
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '1989-1990',
        'name' => '',
        'members' => [
          ['name' => 'Wouter de Vries', 'title' => 'Chair'],
          ['name' => 'Sybren Sijbrandij', 'title' => 'Secretary'],
          ['name' => 'Hung Le', 'title' => 'Treasurer']],
        'figure' => ''
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '1988-1989',
        'name' => '',
        'members' => [
          ['name' => 'Dirk van Dijk', 'title' => 'Chair'],
          ['name' => 'Erik Lukkien', 'title' => 'Secretary'],
          ['name' => 'Menno van der Burg', 'title' => 'Treasurer']],
        'figure' => ''
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '1987-1988',
        'name' => '',
        'members' => [
          ['name' => 'Erik Dalhuijsen', 'title' => 'Chair'],
          ['name' => 'Peter Reijneker', 'title' => 'Secretary'],
          ['name' => 'Gerritjan Wessels', 'title' => 'Treasurer']],
        'figure' => ''
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '1986-1987',
        'name' => '',
        'members' => [
          ['name' => 'Pim Luiten', 'title' => 'Chair'],
	  ['name' => 'Wenzel Hurtak', 'title' => 'Secretary till 1 July'],
	  ['name' => 'Peter Reijneker', 'title' => 'Secretary from 1 July'],
          ['name' => 'Pieter Simon van Dijk', 'title' => 'Treasurer']],
        'figure' => ''
      ]])

      @include("pages.association._board", ['board' => [
        'year' => '1984-1986',
        'name' => '',
        'members' => [
          ['name' => 'Tom Franke', 'title' => 'Chair'],
	  ['name' => 'Guustaaf Brouwer', 'title' => 'Secretary'],
          ['name' => 'Pieter Simon van Dijk', 'title' => 'Treasurer']],
        'figure' => ''
      ]])
@endsection
