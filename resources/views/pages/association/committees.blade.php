@extends('pages.association')

@section('content')

<?php
$volumeNumber = 21;
$committees = [	
	[
		'title' => 'Alumni Committee',
		'translated' => '',
		'description' => 'The Alumni Committee has the noble task of maintaining contact with the alumni of the association. Besides this, every two and a half year the Alumni Committee organises an event for alumni.',
		'link'=> 'alumnicie'
	],
	[

		'title' => 'Borrelcie',
		'translated' => 'Party Committee',
		'description' => 'No society can exist without get-togethers, and that is certainly the case with T.F.V. ‘Professor Francken’! At Francken they are organized by the Borrelcie, or the Party Committee, who make sure that there is regularly something to celebrate at a pub or in the Francken Room, and that the celebration actually takes place. From barbecues to beer-drinking competitions, the Party Committee gets things really humming whilst ensuring that the place is not completely wrecked. To keep up with future activities watch your membership e-mails or check the site regularly.',
		'link'=> 'borrelcie'
	],
	[

		'title' => 'Brouwcie',
		'translated' => 'Brewing Committee',
		'description' => '(DUTCH PAGE) De Brouwcie vond haar oorsprong in een groep op bier georiënteerde studenten van de TFV. Voeg bij het idee om eens zelf een biertje te brouwen bij een vleugje ‘gewoon gaan’ en het duurt niet lang voordat er een pruttelende ketel op het vuur staat. De Commissie is nu al toe aan zijn tweede en verbeterde brouwinstallatie en blijft stevig door automatiseren.',
		'link'=> 'brouwcie'
	],
	[

		'title' => 'Buixie',
		'translated' => 'Foreign Excursion Committee',
		'description' => 'Every year, at the end of the third examination period, the Buixie, or the Foreign Field Trip Committee, organizes a trip to a European country. Last year we went to Scotland! Various activities take place during the trip, including visits to companies and universities to give the participants some idea of what goes on in the world of applied physics outside Groningen. At least one case study has to be carried out for the trip: this is usually arranged by one of the Association´s sponsors.',
		'link'=> 'buixie'
	],
	[

		'title' => 'Compucie',
		'translated' => 'Computer Committee',
		'description' => 'Francken has had its own server since 2007. This hosts the website, the files of the board, committees and members, and music. The Compucie, or the Computer Committee, is responsible for keeping the server and the board’s and members’ workstations up and running. ',
		'link'=> 'compucie'
	],
	[

		'title' => 'Fotocie',
		'translated' => 'Photo Committee',
		'description' => 'A Franckenmember is supposed to be in good condition. Fortunately there is a committee that takes responsibility for this. The Fraccie takes care of the state of our ears, eyes, minds, livers and senses, so that our Franckenmembers remain their beauty. The training schedule consists among other things movie nights, the yearly jam session, members weekends, the poker competition and the Christmas dinner. Keep an eye on the posters and sign up at the form on the Franckendoor.',
		'link'=> 'fotocie'
	],
	[

		'title' => 'Fraccie',
		'translated' => 'Francken Activity Committee',
		'description' => 'A Franckenmember is supposed to be in good condition. Fortunately there is a committee that takes responsibility for this. The Fraccie takes care of the state of our ears, eyes, minds, livers and senses, so that our Franckenmembers remain their beauty. The training schedule consists among other things movie nights, the yearly jam session, members weekends, the poker competition and the Christmas dinner. Keep an eye on the posters and sign up at the form on the Franckendoor.',
		'link'=> 'fraccie'
	],
	[

		'title' => 'Francken Vrij',
		'translated' => '',
		'description' => "One of the few regular events in the student lives of Francken members is the appearance of our popular science magazine Francken Vrij. It comes out three times a year and began volume {$volumeNumber} this academic year. Each edition contains some regular physics columns, looking, for instance, at one of the applied physics departments at the University of Groningen. There is also space devoted to the Association’s activities, such as the field trips and drinks parties organized by the committees.",
		'link'=> 'franckenvrij'
	],
	[

		'title' => 'Intercie',
		'translated' => 'International Committee',
		'description' => 'UPDATE NEEDED',
		'link'=> 'intercie'
	],
	[

		'title' => 'Kascie',
		'translated' => 'Audit Committee',
		'description' => 'The Audit Committee is a committee of the General Membership Assembly that is responsible for overseeing the association’s financial management. It presents a written report of its findings to the Assembly, which is read out there by one of the committee members. It is also tasked with advising the board’s treasurer on request or on its own initiative.',
		'link'=> 'kascie'
	],
	[

		'title' => 'Oefensescie',
		'translated' => 'Practice Session Committee',
		'description' => 'The Practice Session Committee ensures that 10-15 practice sessions a year are held in difficult first-year subjects such as calculus, linear algebra and mechanics. Old exam papers are discussed under the supervision of experienced senior students, and students have an opportunity to ask the questions that so perplex them.',
		'link'=> 'oefensescie'
	],
	[

		'title' => 'Representacie',
		'translated' => 'Presentation Committee',
		'description' => 'The Presentation Committee is responsible for all the decorative posters, television banners and this website.',
		'link'=> 'representacie'
	],
	[

		'title' => 's[ck]rip(t|t?c)ie',
		'translated' => 'Script Committee',
		'description' => 'The Scripting Committee provides every device in the Francken Room capable of executing source code with computerized craziness, wanted or unwanted. Its first triumph was the four-o’clock-beer-time clock on the television, but if we are to believe the rumours going the rounds, there is yet more digital anarchy in store for us.',
		'link'=> 'scriptcie'
	],
	[

		'title' => 'Sjaarscie',
		'translated' => 'First Year`s Committee',
		'description' => 'SOMETHING SOMETHING FIRST YEAR',
		'link'=> 'sjaarscie'
	],
]
?>
  <h1 class="centered-header">
    Committees
 @endsection
