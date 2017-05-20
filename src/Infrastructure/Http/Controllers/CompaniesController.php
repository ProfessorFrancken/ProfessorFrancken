<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers;

final class CompaniesController
{
	private $companies;

    public function __construct()
    {
        $this->companies = [
		  ['name' => 'ASML', 'summary' =>
    'ASML, een succesvolle Nederlandse hightech onderneming, produceert complexe lithografiemachines die chipproducenten inzetten bij de productie van IC’s. De afgelopen jaren zijn de chips steeds sneller, kleiner, slimmer, energiezuiniger en beter betaalbaar geworden en het onderzoek van ASML heeft hieraan een belangrijke bijdrage geleverd. De stuwende kracht achter de technologische doorbraken van ASML zijn ingenieurs die vooruit denken. De medewerkers van ASML behoren tot de creatiefste denkers in de natuurkunde, wiskunde, scheikunde, mechatronica, optica, werktuigkunde, software en informatica. En omdat ASML jaarlijks ruim 1 miljard Euro in R&D investeert, hebben onze mensen de vrijheid en de middelen om de technologische grenzen te verleggen. Zij werken dagelijks samen in hechte multidisciplinaire teams waarin men naar elkaar luistert, van elkaar leert en onderling ideeën uitwisselt.',
    'read-more-at' =>
    'http://www.professorfrancken.nl/wordpress/carriereplaza-2/bedrijfsprofielen/asml/', 'logo' =>
    'http://www.professorfrancken.nl/wordpress/media/images/carriereplaza/ASML.png', 'metadata' => [
        ['term' => 'name', 'description' => 'ASML Holding N.V.'],
        ['term' => 'logo', 'description' => 'File:ASML Holding N.V. logo.svg[200px'],
        ['term' => 'type', 'description' => 'Naamloze vennootschap '],
        ['term' => 'traded_as', 'description' => 'Euronext[ASML[NL0010273215[XAMS, NASDAQ[ASML'],
        ['term' => 'foundation', 'description' => 'start date and age[1984'],
        ['term' => 'location', 'description' => 'Veldhoven, Netherlands'],
        ['term' => 'key_people', 'description' =>
            'Peter Wennink (chief executive officer[CEO), Arthur van der Poel  (Chairman of the supervisory board)'
        ],
        ['term' => 'products', 'description' =>
            'Photolithography systems for the semiconductor industry'
        ],
        ['term' => 'industry', 'description' => 'Semiconductor industry'],
        ['term' => 'revenue', 'description' => 'Euro[€6.794 billion (2016)'],
        ['term' => 'operating_income', 'description' => '€1.526 billion (2014)'],
        ['term' => 'net_income', 'description' => '€1.471 billion (2016)'],
        ['term' => 'assets', 'description' => '€17.205 billion (2016)'],
        ['term' => 'equity', 'description' => '€9.820 billion (2016)'],
        ['term' => 'num_employees', 'description' => '15,910 (2016)'],
        ['term' => 'intl', 'description' => 'yes'],
        ['term' => 'homepage', 'description' => 'http://asml.com'],
    ]
], ['name' => 'De Nederlandsche Bank ', 'summary' =>
    'Werken aan vertrouwen. In een professionele werkomgeving die door de actualiteit en de dynamiek van de financiële wereld op een hoog peil staat. Multidisciplinair, in een internationale context. Bij een organisatie met een grote maatschappelijke verantwoordelijkheid - wát we doen, doet er toe. En dat doen we met integriteit, loyaliteit en een groot saamhorigheidsgevoel. Onze succesfactoren. ',
    'read-more-at' =>
    'http://www.professorfrancken.nl/wordpress/carriere/bedrijfsprofielen/de-nederlandsche-bank/',
    'logo' => 'http://www.professorfrancken.nl/wordpress/media/images/carriereplaza/dnb.png',
    'metadata' => [
        ['term' => 'name', 'description' => 'ASML Holding N.V.'],
        ['term' => 'logo', 'description' => 'File:ASML Holding N.V. logo.svg[200px'],
        ['term' => 'type', 'description' => 'Naamloze vennootschap '],
        ['term' => 'traded_as', 'description' => 'Euronext[ASML[NL0010273215[XAMS, NASDAQ[ASML'],
        ['term' => 'foundation', 'description' => 'start date and age[1984'],
        ['term' => 'location', 'description' => 'Veldhoven, Netherlands'],
        ['term' => 'key_people', 'description' =>
            'Peter Wennink (chief executive officer[CEO), Arthur van der Poel  (Chairman of the supervisory board)'
        ],
        ['term' => 'products', 'description' =>
            'Photolithography systems for the semiconductor industry'
        ],
        ['term' => 'industry', 'description' => 'Semiconductor industry'],
        ['term' => 'revenue', 'description' => 'Euro[€6.794 billion (2016)'],
        ['term' => 'operating_income', 'description' => '€1.526 billion (2014)'],
        ['term' => 'net_income', 'description' => '€1.471 billion (2016)'],
        ['term' => 'assets', 'description' => '€17.205 billion (2016)'],
        ['term' => 'equity', 'description' => '€9.820 billion (2016)'],
        ['term' => 'num_employees', 'description' => '15,910 (2016)'],
        ['term' => 'intl', 'description' => 'yes'],
        ['term' => 'homepage', 'description' => 'http://asml.com'],
    ]
], ['name' => 'DNV GL', 'summary' =>
    'Gedreven door onze doelstelling het beschermen van leven, bezit en het milieu (safeguarding life, property and the environment), GL stelt DNV GL organisaties in staat om de veiligheid en duurzaamheid van hun bedrijf te bevorderen. Wij bieden de classificatie en technische zekerheid, samen met software en onafhankelijke deskundige adviesdiensten aan de maritieme, olie en gas, en energie-industrie. Wij bieden ook certificeringsdiensten aan in breed scala van industrieën.',
    'read-more-at' => 'http://www.professorfrancken.nl/wordpress/carriere/bedrijfsprofielen/kema/',
    'logo' => 'http://www.professorfrancken.nl/wordpress/media/images/carriereplaza/kema.png',
    'metadata' => [
        ['term' => 'name', 'description' => 'ASML Holding N.V.'],
        ['term' => 'logo', 'description' => 'File:ASML Holding N.V. logo.svg[200px'],
        ['term' => 'type', 'description' => 'Naamloze vennootschap '],
        ['term' => 'traded_as', 'description' => 'Euronext[ASML[NL0010273215[XAMS, NASDAQ[ASML'],
        ['term' => 'foundation', 'description' => 'start date and age[1984'],
        ['term' => 'location', 'description' => 'Veldhoven, Netherlands'],
        ['term' => 'key_people', 'description' =>
            'Peter Wennink (chief executive officer[CEO), Arthur van der Poel  (Chairman of the supervisory board)'
        ],
        ['term' => 'products', 'description' =>
            'Photolithography systems for the semiconductor industry'
        ],
        ['term' => 'industry', 'description' => 'Semiconductor industry'],
        ['term' => 'revenue', 'description' => 'Euro[€6.794 billion (2016)'],
        ['term' => 'operating_income', 'description' => '€1.526 billion (2014)'],
        ['term' => 'net_income', 'description' => '€1.471 billion (2016)'],
        ['term' => 'assets', 'description' => '€17.205 billion (2016)'],
        ['term' => 'equity', 'description' => '€9.820 billion (2016)'],
        ['term' => 'num_employees', 'description' => '15,910 (2016)'],
        ['term' => 'intl', 'description' => 'yes'],
        ['term' => 'homepage', 'description' => 'http://asml.com'],
    ]
], ['name' => 'Langwyck Campus Recruitment', 'summary' =>
    'Langwyck Campus Recruitment verbindt financieel en technisch hogeropgeleiden met aantrekkelijke startfuncties. LCR is erop gericht om steeds de best mogelijke eerste stappen in een carrière te faciliteren. Daarbij brengt LCR de behoeftes van bedrijven in kaart, terwijl wordt geluisterd naar de wensen van de geselecteerde kandidaten.',
    'read-more-at' =>
    'http://www.professorfrancken.nl/wordpress/carriereplaza-2/bedrijfsprofielen/langwyck-campus-recruitment/',
    'logo' => 'http://www.professorfrancken.nl/wordpress/media/images/carriereplaza/Langwyck.png',
    'metadata' => [
        ['term' => 'name', 'description' => 'ASML Holding N.V.'],
        ['term' => 'logo', 'description' => 'File:ASML Holding N.V. logo.svg[200px'],
        ['term' => 'type', 'description' => 'Naamloze vennootschap '],
        ['term' => 'traded_as', 'description' => 'Euronext[ASML[NL0010273215[XAMS, NASDAQ[ASML'],
        ['term' => 'foundation', 'description' => 'start date and age[1984'],
        ['term' => 'location', 'description' => 'Veldhoven, Netherlands'],
        ['term' => 'key_people', 'description' =>
            'Peter Wennink (chief executive officer[CEO), Arthur van der Poel  (Chairman of the supervisory board)'
        ],
        ['term' => 'products', 'description' =>
            'Photolithography systems for the semiconductor industry'
        ],
        ['term' => 'industry', 'description' => 'Semiconductor industry'],
        ['term' => 'revenue', 'description' => 'Euro[€6.794 billion (2016)'],
        ['term' => 'operating_income', 'description' => '€1.526 billion (2014)'],
        ['term' => 'net_income', 'description' => '€1.471 billion (2016)'],
        ['term' => 'assets', 'description' => '€17.205 billion (2016)'],
        ['term' => 'equity', 'description' => '€9.820 billion (2016)'],
        ['term' => 'num_employees', 'description' => '15,910 (2016)'],
        ['term' => 'intl', 'description' => 'yes'],
        ['term' => 'homepage', 'description' => 'http://asml.com'],
    ]
], ['name' => 'Optiver', 'summary' =>
    'We are Optiver, an international trading company, headquartered in Amsterdam. With more than 700 colleagues across four continents we constantly offer fair and highly competitive prices for the buying and selling of stocks, bonds, options, futures, ETF’s et cetera. It is called ‘market making’. We build markets and provide liquidity to international exchanges in Europe, the US and Asia Pacific.
    We make financial markets fair, open and reliable.We do not only trade when we feel like it.Not only when our outlook is bright,
        but 24 hours a day.Whichever way the markets go,
        we are there, always at our own risk, using our own capital.‘Value the difference’ sums it up perfectly
        .It explains in a nutshell what we do every day.It also invites you to explore how we do our job differently
                .
            ',
            'read-more-at' =>
            'http://www.professorfrancken.nl/wordpress/carriereplaza-2/bedrijfsprofielen/optiver//',
            'logo' =>
            'http://www.professorfrancken.nl/wordpress/media/images/carriereplaza/Optiver.png',
            'metadata' => [
                ['term' => 'name', 'description' => 'ASML Holding N.V.'],
                ['term' => 'logo', 'description' => 'File:ASML Holding N.V. logo.svg[200px'],
                ['term' => 'type', 'description' => 'Naamloze vennootschap '],
                ['term' => 'traded_as', 'description' =>
                    'Euronext[ASML[NL0010273215[XAMS, NASDAQ[ASML'
                ],
                ['term' => 'foundation', 'description' => 'start date and age[1984'],
                ['term' => 'location', 'description' => 'Veldhoven, Netherlands'],
                ['term' => 'key_people', 'description' =>
                    'Peter Wennink (chief executive officer[CEO), Arthur van der Poel  (Chairman of the supervisory board)'
                ],
                ['term' => 'products', 'description' =>
                    'Photolithography systems for the semiconductor industry'
                ],
                ['term' => 'industry', 'description' => 'Semiconductor industry'],
                ['term' => 'revenue', 'description' => 'Euro[€6.794 billion (2016)'],
                ['term' => 'operating_income', 'description' => '€1.526 billion (2014)'],
                ['term' => 'net_income', 'description' => '€1.471 billion (2016)'],
                ['term' => 'assets', 'description' => '€17.205 billion (2016)'],
                ['term' => 'equity', 'description' => '€9.820 billion (2016)'],
                ['term' => 'num_employees', 'description' => '15,910 (2016)'],
                ['term' => 'intl', 'description' => 'yes'],
                ['term' => 'homepage', 'description' => 'http://asml.com'],
            ]
], ['name' => 'Philips Drachten ', 'summary' =>
    'Onze Consumer Lifestyle-tak speelt in op de behoeften van consumenten over de hele wereld. Zo inspireren wij hen en maken het voor hen mogelijk om goed te leven, gezond te blijven en van het leven te genieten. Mensen helpen gezonder en prettiger te leven Consumenten over heel de wereld willen hun eigen gezondheid en welzijn en de gezondheid en het welzijn van hun gezin waarborgen en verbeteren. Philips Consumer Lifestyle wil graag uitgroeien tot een toonaangevende speler op het gebied van gezondheid en welzijn door een constante stroom lokaal relevante en zinvolle innovaties te bieden. ',
    'read-more-at' =>
    'http://www.professorfrancken.nl/wordpress/carriereplaza-2/bedrijfsprofielen/philips-drachten/',
    'logo' => 'http://www.professorfrancken.nl/wordpress/media/images/carriereplaza/philips.png',
    'metadata' => [
        ['term' => 'name', 'description' => 'ASML Holding N.V.'],
        ['term' => 'logo', 'description' => 'File:ASML Holding N.V. logo.svg[200px'],
        ['term' => 'type', 'description' => 'Naamloze vennootschap '],
        ['term' => 'traded_as', 'description' => 'Euronext[ASML[NL0010273215[XAMS, NASDAQ[ASML'],
        ['term' => 'foundation', 'description' => 'start date and age[1984'],
        ['term' => 'location', 'description' => 'Veldhoven, Netherlands'],
        ['term' => 'key_people', 'description' =>
            'Peter Wennink (chief executive officer[CEO), Arthur van der Poel  (Chairman of the supervisory board)'
        ],
        ['term' => 'products', 'description' =>
            'Photolithography systems for the semiconductor industry'
        ],
        ['term' => 'industry', 'description' => 'Semiconductor industry'],
        ['term' => 'revenue', 'description' => 'Euro[€6.794 billion (2016)'],
        ['term' => 'operating_income', 'description' => '€1.526 billion (2014)'],
        ['term' => 'net_income', 'description' => '€1.471 billion (2016)'],
        ['term' => 'assets', 'description' => '€17.205 billion (2016)'],
        ['term' => 'equity', 'description' => '€9.820 billion (2016)'],
        ['term' => 'num_employees', 'description' => '15,910 (2016)'],
        ['term' => 'intl', 'description' => 'yes'],
        ['term' => 'homepage', 'description' => 'http://asml.com'],
    ]
], ['name' => 'Nedap', 'summary' =>
    'City accessibility in a time of continuous population growth. Quality healthcare in the face of shrinking budgets. Security requirements in a world with increasing risks. These are just a few of the issues that Nedap people work on each day. We believe that technology can provide an important contribution to resolve major issues.
    Nedap’ s mission: Moving markets with technology that matters.Our technology creates added value through products that solve relevant problems
    .But it’ s not the technology that is paramount… it’ s the way that people use it.Therefore, we strive to incorporate the very latest technologies in
    creative, innovative ways.The result ? Relevant, elegant and user - friendly solutions.
    ',
    'read-more-at' =>
    'http://www.professorfrancken.nl/wordpress/carriereplaza-2/bedrijfsprofielen/nedap/', 'logo' =>
    'http://www.professorfrancken.nl/wordpress/media/images/carriereplaza/Nedap.png', 'metadata' => [
        ['term' => 'name', 'description' => 'ASML Holding N.V.'],
        ['term' => 'logo', 'description' => 'File:ASML Holding N.V. logo.svg[200px'],
        ['term' => 'type', 'description' => 'Naamloze vennootschap '],
        ['term' => 'traded_as', 'description' => 'Euronext[ASML[NL0010273215[XAMS, NASDAQ[ASML'],
        ['term' => 'foundation', 'description' => 'start date and age[1984'],
        ['term' => 'location', 'description' => 'Veldhoven, Netherlands'],
        ['term' => 'key_people', 'description' =>
            'Peter Wennink (chief executive officer[CEO), Arthur van der Poel  (Chairman of the supervisory board)'
        ],
        ['term' => 'products', 'description' =>
            'Photolithography systems for the semiconductor industry'
        ],
        ['term' => 'industry', 'description' => 'Semiconductor industry'],
        ['term' => 'revenue', 'description' => 'Euro[€6.794 billion (2016)'],
        ['term' => 'operating_income', 'description' => '€1.526 billion (2014)'],
        ['term' => 'net_income', 'description' => '€1.471 billion (2016)'],
        ['term' => 'assets', 'description' => '€17.205 billion (2016)'],
        ['term' => 'equity', 'description' => '€9.820 billion (2016)'],
        ['term' => 'num_employees', 'description' => '15,910 (2016)'],
        ['term' => 'intl', 'description' => 'yes'],
        ['term' => 'homepage', 'description' => 'http://asml.com'],
    ]
], ['name' => 'Schut', 'summary' =>
    'chut Geometrische Meettechniek is een internationale organisatie met vijf vestigingen in Europa en de hoofdvestiging in Groningen. Het bedrijf is ISO 9001 gecertificeerd en gespecialiseerd in de ontwikkeling, productie en verkoop van precisie meetinstrumenten en -systemen. Aangezien we onze activiteiten uitbreiden, zijn we continu op zoek naar enthousiaste medewerkers om ons team te versterken.',
    'read-more-at' => 'http://www.professorfrancken.nl/wordpress/bedrijfsprofielen/schut/', 'logo' =>
    'http://www.professorfrancken.nl/wordpress/wp-content/uploads/2013/03/SchutReflexBlue.jpg',
    'metadata' => [
        ['term' => 'name', 'description' => 'ASML Holding N.V.'],
        ['term' => 'logo', 'description' => 'File:ASML Holding N.V. logo.svg[200px'],
        ['term' => 'type', 'description' => 'Naamloze vennootschap '],
        ['term' => 'traded_as', 'description' => 'Euronext[ASML[NL0010273215[XAMS, NASDAQ[ASML'],
        ['term' => 'foundation', 'description' => 'start date and age[1984'],
        ['term' => 'location', 'description' => 'Veldhoven, Netherlands'],
        ['term' => 'key_people', 'description' =>
            'Peter Wennink (chief executive officer[CEO), Arthur van der Poel  (Chairman of the supervisory board)'
        ],
        ['term' => 'products', 'description' =>
            'Photolithography systems for the semiconductor industry'
        ],
        ['term' => 'industry', 'description' => 'Semiconductor industry'],
        ['term' => 'revenue', 'description' => 'Euro[€6.794 billion (2016)'],
        ['term' => 'operating_income', 'description' => '€1.526 billion (2014)'],
        ['term' => 'net_income', 'description' => '€1.471 billion (2016)'],
        ['term' => 'assets', 'description' => '€17.205 billion (2016)'],
        ['term' => 'equity', 'description' => '€9.820 billion (2016)'],
        ['term' => 'num_employees', 'description' => '15,910 (2016)'],
        ['term' => 'intl', 'description' => 'yes'],
        ['term' => 'homepage', 'description' => 'http://asml.com'],
    ]
], ['name' => 'TMC', 'summary' =>
    'TMC Physics is an enthusiastic group of experts. Our group contains optical, fluid dynamics, thermal, (statistical) modeling and system architecture specialists who work with state of the art technology companies. Our assignments range from theoretical research to application engineering. The roles we fulfill are ranging from researcher or project leader to R&D program manager. ',
    'read-more-at' => 'http://www.professorfrancken.nl/wordpress/bedrijfsprofielen/tmc/', 'logo' =>
    'http://www.professorfrancken.nl/wordpress/wp-content/uploads/2013/03/TMC_Logo_Vierkantjes_CMYK.png',
    'metadata' => [
        ['term' => 'name', 'description' => 'ASML Holding N.V.'],
        ['term' => 'logo', 'description' => 'File:ASML Holding N.V. logo.svg[200px'],
        ['term' => 'type', 'description' => 'Naamloze vennootschap '],
        ['term' => 'traded_as', 'description' => 'Euronext[ASML[NL0010273215[XAMS, NASDAQ[ASML'],
        ['term' => 'foundation', 'description' => 'start date and age[1984'],
        ['term' => 'location', 'description' => 'Veldhoven, Netherlands'],
        ['term' => 'key_people', 'description' =>
            'Peter Wennink (chief executive officer[CEO), Arthur van der Poel  (Chairman of the supervisory board)'
        ],
        ['term' => 'products', 'description' =>
            'Photolithography systems for the semiconductor industry'
        ],
        ['term' => 'industry', 'description' => 'Semiconductor industry'],
        ['term' => 'revenue', 'description' => 'Euro[€6.794 billion (2016)'],
        ['term' => 'operating_income', 'description' => '€1.526 billion (2014)'],
        ['term' => 'net_income', 'description' => '€1.471 billion (2016)'],
        ['term' => 'assets', 'description' => '€17.205 billion (2016)'],
        ['term' => 'equity', 'description' => '€9.820 billion (2016)'],
        ['term' => 'num_employees', 'description' => '15,910 (2016)'],
        ['term' => 'intl', 'description' => 'yes'],
        ['term' => 'homepage', 'description' => 'http://asml.com'],
    ]
], ['name' => 'Procam', 'summary' =>
    'Eindelijk. Je studie zit erop. Je carrière gaat beginnen. Maar waar? Hoe pak je het aan? Ons advies: Ga niet meteen in op elk aanbod. Plan je carrière zorgvuldig vanaf de allereerste dag. Draai het eens om. Vraag je niet af wie jou wil hebben maar waar jij wilt werken. Waar komt jouw talent het best tot zijn recht? Welke organisatie past bij je? Lastige vragen als je nog geen werkervaring hebt en de werkgevers alleen kent van fraaie advertenties. Procam laat je kennis maken met toporganisaties in Nederland. En met jezelf. Wij geven je het inzicht, de coaching en de hulpmiddelen om gedurende het traject de verschillende Talent Wings te halen. Zo kun je gericht aan je carrière werken. Jouw carrière.',
    'read-more-at' =>
    'http://www.professorfrancken.nl/wordpress/carriere/bedrijfsprofielen/procam/', 'logo' =>
    'http://www.professorfrancken.nl/wordpress/media/images/carriereplaza/procam.png', 'metadata' => [
        ['term' => 'name', 'description' => 'ASML Holding N.V.'],
        ['term' => 'logo', 'description' => 'File:ASML Holding N.V. logo.svg[200px'],
        ['term' => 'type', 'description' => 'Naamloze vennootschap '],
        ['term' => 'traded_as', 'description' => 'Euronext[ASML[NL0010273215[XAMS, NASDAQ[ASML'],
        ['term' => 'foundation', 'description' => 'start date and age[1984'],
        ['term' => 'location', 'description' => 'Veldhoven, Netherlands'],
        ['term' => 'key_people', 'description' =>
            'Peter Wennink (chief executive officer[CEO), Arthur van der Poel  (Chairman of the supervisory board)'
        ],
        ['term' => 'products', 'description' =>
            'Photolithography systems for the semiconductor industry'
        ],
        ['term' => 'industry', 'description' => 'Semiconductor industry'],
        ['term' => 'revenue', 'description' => 'Euro[€6.794 billion (2016)'],
        ['term' => 'operating_income', 'description' => '€1.526 billion (2014)'],
        ['term' => 'net_income', 'description' => '€1.471 billion (2016)'],
        ['term' => 'assets', 'description' => '€17.205 billion (2016)'],
        ['term' => 'equity', 'description' => '€9.820 billion (2016)'],
        ['term' => 'num_employees', 'description' => '15,910 (2016)'],
        ['term' => 'intl', 'description' => 'yes'],
        ['term' => 'homepage', 'description' => 'http://asml.com'],
    ]
],
['name' => 'Valersi', 'summary' =>
    '<p>Op zoek naar <a href="https://valersi.nl/">akoestisch onderzoek</a>, een specialist in ruimtelijke ordening of advies bij geluidvraagstukken? Ons team met meer dan 25 jaar ervaring in geluid denkt graag met u mee.</p><p>Valersi meet, weet en analyseert.</p><p><a href="https://valersi.nl/" >Valersi.nl</a></p>
',
    'read-more-at' =>
    'https://valersi.nl', 'logo' =>
    '/images/footer/valersi.png', 'metadata' => [
        ['term' => 'homepage', 'description' => 'https://valersi.nl/'],
    ]
]
        ];
    }

    public function index()
    {
        return view('career.companies.index')
            ->with('companies', $this->companies);
    }

    public function show($slug)
    {
        $company = array_first(
            array_filter($this->companies, function ($company) use ($slug){
                return str_slug($company['name']) === $slug;
            })
        );

        return view('career.companies.show')
            ->with('companies', $this->companies)
            ->with('company', $company);
    }
}
