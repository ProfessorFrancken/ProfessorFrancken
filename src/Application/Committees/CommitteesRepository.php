<?php

declare(strict_types=1);

namespace Francken\Application\Committees;

final class CommitteesRepository
{
    private $committees;

    public function __construct()
    {
        $this->committees = [
            [
                "id" => 35,
                "title" => "Adtie",
                "email" => "",
                "logo" => "",
                "link" => "adtie",
                "page" => "pages.association.committees.adtie",
                "members" => [
                    new CommitteeMember(
                        1403,
                        "Mark",
                        "Redeman"
                    ),
                    new CommitteeMember(
                        797,
                        "Sjoerd",
                        "Meesters"
                    ),
                    new CommitteeMember(
                        1176,
                        "Friso",
                        "Wobben"
                    ),
                    new CommitteeMember(
                        1172,
                        "Gerjan",
                        "Wielink"
                    ),
                    new CommitteeMember(
                        1293,
                        "Anton",
                        "Jansen"
                    ),
                    new CommitteeMember(
                        1359,
                        "Diewertje",
                        "Douglas"
                    ),
                    new CommitteeMember(
                        1312,
                        "Jasper",
                        "Pluijmers"
                    ),
                ]
                ],
            ],
            [
                "id" => 35,
                "title" => "Alumnicie",
                "email" => "alumni@professorfrancken.nl",
                "logo" => "https://borrelcie.vodka/tmp/Alumnicie.png",
                "link" => "alumnicie",
                "page" => "pages.association.committees.alumnicie",
                "members" => [
                    new CommitteeMember(
                        1266,
                        "Anne",
                        "in 't Veld"
                    ),
                    new CommitteeMember(
                        1176,
                        "Friso",
                        "Wobben"
                    ),
                    new CommitteeMember(
                        1206,
                        "Max",
                        "Kamperman"
                    ),
                    new CommitteeMember(
                        1149,
                        "Janneke",
                        "Janssens"
                    ),
                    new CommitteeMember(
                        1163,
                        "Willeke",
                        "Mulder"
                    ),
                ]
                ],
            ],
            [
                "id" => 404,
                "title" => "Almanakcie",
                "email" => "almanakfrancken@gmail.com",
                "logo" => "",
                "link" => "almanakcie",
                "page" => "pages.association.committees.almanakcie",
                "members" => [
                    new CommitteeMember(
                        1173,
                        "Steven",
                        "Groen"
                    ),
                    new CommitteeMember(
                        1608,
                        "Su-Elle",
                        "Kamps"
                    ),                   
                    new CommitteeMember(
                        1001,
                        "Carlos",
                        "Bril"
                    ),
                    new CommitteeMember(
                        1042,
                        "Janna",
                        "de Wit"
                    ),
                    new CommitteeMember(
                        1360,
                        "Pieter",
                        "Wolff"
                    ),
                    new CommitteeMember(
                        1312,
                        "Jasper",
                        "Pluijmers"
                    ),
                    new CommitteeMember(
                        1172,
                        "Gerjan",
                        "Wielink"
                    ),
                    new CommitteeMember(
                        1361,
                        "Jelle",
                        "Bor"
                    ),
            ],
            [
                "id" => 404,
                "title" => "Bincie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Bincie.png",
                "link" => "bincie",
                "page" => "pages.association.committees.bincie",
            ],
            [
                "id" => 19,
                "title" => "Borrelcie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Borrelcie.png",
                "link" => "borrelcie",
                "page" => "pages.association.committees.borrelcie",
                "members" => [
                    new CommitteeMember(
                        1582,
                        "Joris",
                        "Doting"
                    ),
                    new CommitteeMember(
                        1372,
                        "Ids",
                        "Schiere"
                    ),
                    new CommitteeMember(
                        1333,
                        "Arjen",
                        "Kramer"
                    ),
                    new CommitteeMember(
                        1265,
                        "Gerben",
                        "Hijlkema"
                    ),
                    new CommitteeMember(
                        1710,
                        "Bradley",
                        "Spronk"
                    ),
                    new CommitteeMember(
                        1880,
                        "Wim",
                        "Drenth"
                    ),
                    new CommitteeMember(
                        1945,
                        "Sammie",
                        "Mulder"
                    ),
                    new CommitteeMember(
                        1593,
                        "Simone",
                        "Kockelkorn"
                    ),
                    new CommitteeMember(
                        1926,
                        "Lasse",
                        "Vulto"
                    ),
                    new CommitteeMember(
                        1915,
                        "Patrick",
                        "Ziengs"
                    ),
                    new CommitteeMember(
                        1931,
                        "Pieter",
                        "Buisman"
                    ),
                    new CommitteeMember(
                        1350,
                        "Berend",
                        "Mintjes"
                    ),
                   
                    ]
                ],
            ],
            [
                "id" => 33,
                "title" => "Brouwcie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Brouwcie.png",
                "link" => "brouwcie",
                "page" => "pages.association.committees.brouwcie",
                "members" => [
                    new CommitteeMember(
                        1143,
                        "Hilbert",
                        "van Loo"
                    ),
                    new CommitteeMember(
                        934,
                        "Marten",
                        "Koopmans"
                    ),
                    new CommitteeMember(
                        932,
                        "Bauke",
                        "Steensma"
                    ),
                    new CommitteeMember(
                        916,
                        "Camiel",
                        "van Hooff"
                    ),
                    new CommitteeMember(
                        918,
                        "Rick",
                        "Meijerink"
                    ),
                    new CommitteeMember(
                        924,
                        "Wopke",
                        "Hellinga"
                    ),
                    new CommitteeMember(
                        1345,
                        "Bas",
                        "de Jong"
                    ),
                    new CommitteeMember(
                        1172,
                        "Gerjan",
                        "Wielink"
                    ),
                    new CommitteeMember(
                        1206,
                        "Max",
                        "Kamperman"
                    ),
                    new CommitteeMember(
                        1265,
                        "Gerben",
                        "Hijlkema"
                    ),
                    ]
                ],
            ],
            [
                "id" => 2,
                "title" => "Buixie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Buixie.png",
                "link" => "buixie",
                "page" => "pages.association.committees.buixie",
                "members" => [
                    new CommitteeMember(
                        1187,
                        "Jasper",
                        "Staal"
                    ),
                    new CommitteeMember(
                        1582,
                        "Joris",
                        "Doting"
                    ),
                    new CommitteeMember(
                        1571,
                        "Chantal",
                        "Kool"
                    ),
                    new CommitteeMember(
                        1178,
                        "Leon",
                        "Trustram"
                    ),
                    new CommitteeMember(
                        1817,
                        "Emiel",
                        "de Wit"
                    ),
                    new CommitteeMember(
                        1913,
                        "Carla",
                        "Olsthoorn"
                    ),
                    ]
            ],
            [
                "id" => 53,
                "title" => "CoDcie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/CoDcie.png",
                "link" => "codcie",
                "page" => "pages.association.committees.codcie",
            ],
            [
                "id" => 1,
                "title" => "Compucie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Compucie.png",
                "link" => "compucie",
                "page" => "pages.association.committees.compucie",
                "members" => [
                    new CommitteeMember(
                        1176,
                        "Friso",
                        "Wobben"
                    ),
                    new CommitteeMember(
                        1143,
                        "Hilbert",
                        "van Loo"
                    ),
                    new CommitteeMember(
                        1172,
                        "Gerjan",
                        "Wielink"
                    ),
                    new CommitteeMember(
                        1293,
                        "Anton",
                        "Jansen"
                    ),
                    new CommitteeMember(
                        728,
                        "Ypke",
                        "Jager"
                    ),
                    new CommitteeMember(
                        442,
                        "Gert",
                        "Eising"
                    ),
                    new CommitteeMember(
                        439,
                        "Laurens-Jan",
                        "Soer"
                    ),
                    ]
            ],
            [
                "id" => 21,
                "title" => "Fotocie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Fotocie.png",
                "link" => "fotocie",
                "page" => "pages.association.committees.fotocie",
                "members" => [
                    new CommitteeMember(
                        1875,
                        "Randy",
                        "Wind"
                    ),                    
                    new CommitteeMember(
                        1817,
                        "Emiel",
                        "de Wit"
                    ),
                    new CommitteeMember(
                        1924,
                        "Robert",
                        "Mol"
                    ),                    
                    new CommitteeMember(
                        1667,
                        "Floris",
                        "Westerman"
                    ),
                    new CommitteeMember(
                        1608,
                        "Su-Elle",
                        "Kamps"
                    ),


                    ]
            ],
            ]
            [
                "id" => 9,
                "title" => "Fraccie",
                "email" => "Fraccie@professorfrancken.nl",
                "logo" => "https://borrelcie.vodka/tmp/Fraccie.png",
                "link" => "fraccie",
                "page" => "pages.association.committees.fraccie",
                "members" => [
                    new CommitteeMember(
                        1786,
                        "Tamara",
                        "Kok"
                    ),
                    new CommitteeMember(
                        1760,
                        "Jeanne",
                        "van Zuilen"
                    ),
                    new CommitteeMember(
                        1774,
                        "Alida",
                        "Hunnink"
                    ),
                    new CommitteeMember(
                        1209,
                        "Laurens",
                        "Even"
                    ),
                    new CommitteeMember(
                        1732,
                        "Puck",
                        "Planje"
                    ),
                    new CommitteeMember(
                        1942,
                        "Sven",
                        "Cats"
                    ),
                    new CommitteeMember(
                        1753,
                        "Vincent",
                        "Tissing"
                    ), 
                    new CommitteeMember(
                        1049,
                        "Steven",
                        "Hiemstra"
                    ),                    
            ],
            [
                "id" => 10,
                "title" => "Francken Vrij",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Francken_Vrij.png",
                "link" => "francken-vrij",
                "page" => "pages.association.committees.francken-vrij",
                "members" => [
                    new CommitteeMember(
                        1336,
                        "Evelien",
                        "Zwanenburg"
                    ),
                    new CommitteeMember(
                        1173,
                        "Steven",
                        "Groen"
                    ),
                    new CommitteeMember(
                        1172,
                        "Gerjan",
                        "Wielink"
                    ),
                    new CommitteeMember(
                        1037,
                        "Kathinka",
                        "Frieswijk"
                    ),
                    new CommitteeMember(
                        1045,
                        "Paul",
                        "Wijnbergen"
                    ),
                    new CommitteeMember(
                        1817,
                        "Emiel",
                        "de Wit"
                    ),
                    new CommitteeMember(
                        1905,
                        "Shreya",
                        "Shrestha"
                    ),         
            ],
            [
                "id" => 32,
                "title" => "Intercie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Intercie.png",
                "link" => "intercie",
                "page" => null,
                "members" => [
                    new CommitteeMember(
                        1001,
                        "Carlos",
                        "Bril"
                    ),
                    new CommitteeMember(
                        1960,
                        "Melav",
                        "Salih"
                    ),
                    new CommitteeMember(
                        1830,
                        "Aoibhin",
                        "Quinn"
                    ),
                    new CommitteeMember(
                        1807,
                        "Callum",
                        "Blair"
                    ),                         
            ],
            [
                "id" => 12,
                "title" => "Kascie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Kascie.png",
                "link" => "kascie",
                "page" => "pages.association.committees.kascie",
                "members" => [
                    new CommitteeMember(
                        1001,
                        "Steven",
                        "Groen"
                    ),
                    new CommitteeMember(
                        1336,
                        "Evelien",
                        "Zwanenburg"
                    ),
                    new CommitteeMember(
                        1960,
                        "David",
                        "Koning"
                    ),
                    new CommitteeMember(
                        1830,
                        "Arjen",
                        "Kramer"
                    ),
            ],
            [
                "id" => 18,
                "title" => "Oefensescie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Oefensescie.png",
                "link" => "oefensescie",
                "page" => "pages.association.committees.oefensescie",
                "members" => [
                    new CommitteeMember(
                        1724,
                        "Anna",
                        "Kenbeek"
                    ),
                    new CommitteeMember(
                        1140,
                        "Olivier",
                        "Gelling"
                    ),
                    new CommitteeMember(
                        1359,
                        "Diewertje",
                        "Douglas"
                    ),
                    new CommitteeMember(
                        1824,
                        "Lars",
                        "van der Laan"
                    ),
                    new CommitteeMember(
                        1846,
                        "Thijs",
                        "Qualm"
                    ),
                    new CommitteeMember(
                        1851,
                        "Richard",
                        "Borgers"
                    ),
                    new CommitteeMember(
                        1942,
                        "Sven",
                        "Cats"
                    ),
            ],
            [
                "id" => 5,
                "title" => "Representacie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Representacie.png",
                "link" => "representacie",
                "page" => "pages.association.committees.representacie",
                "members" => [
                    new CommitteeMember(
                        1042,
                        "Janna",
                        "de Wit"
                    ),
                    new CommitteeMember(
                        1149,
                        "Janneke",
                        "Janssens"
                    ),
                    new CommitteeMember(
                        1670,
                        "Mees",
                        "Hoogland"
                    ),
                    new CommitteeMember(
                        999,
                        "Joris",
                        "Admiraal"
                    ),
                    new CommitteeMember(
                        1174,
                        "David",
                        "Koning"
                    ),
                    new CommitteeMember(
                        1172,
                        "Gerjan",
                        "Wielink"
                    ),
                    new CommitteeMember(
                        1163,
                        "Willeke",
                        "Mulder"
                    ),
                    new CommitteeMember(
                        1593,
                        "Simone",
                        "Kockelkorn"
                    ),
                    new CommitteeMember(
                        1469,
                        "Robert",
                        "van der Meer"
                    ),
            ],
            [
                "id" => 24,
                "title" => "Sjaarscie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Sjaarscie.png",
                "link" => "sjaarscie",
                "page" => "pages.association.committees.sjaarcie",
                "members" => [
                    new CommitteeMember(
                        1960,
                        "Melav",
                        "Salih"
                    ),
                    new CommitteeMember(
                        1882,
                        "Robin",
                        "Dorstijn"
                    ),
                    new CommitteeMember(
                        1906,
                        "Jada",
                        "Tijssen"
                    ),
                    new CommitteeMember(
                        1914,
                        "Dennis",
                        "van der Veen"
                    ),
                    new CommitteeMember(
                        1904,
                        "Dominic",
                        "Eelkema"
                    ),
                    new CommitteeMember(
                        1918,
                        "Jelmer",
                        "Zijlstra"
                    ),
                    new CommitteeMember(
                        1901,
                        "Koen",
                        "van der Heijden"
                    ),
                    new CommitteeMember(
                        1888,
                        "Sule",
                        "Daley"
                    ),
                    new CommitteeMember(
                        1913,
                        "Carla",
                        "Olsthoorn"
                    ),
                    new CommitteeMember(
                        1926,
                        "Lasse",
                        "Vulto"
                    ),
                    new CommitteeMember(
                        1915,
                        "Patrick",
                        "Ziengs"
                    ),
                    new CommitteeMember(
                        1931,
                        "Pieter",
                        "Buisman"
                    ),
                    
            ],
            [
                "id" => 29,
                "title" => "Sportcie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Sportcie.png",
                "link" => "sportcie",
                "page" => null,
                "members" => [
                    new CommitteeMember(
                        1339,
                        "Sietske",
                        "Dijkstra"
                    ),
                    new CommitteeMember(
                        1265,
                        "Gerben",
                        "Hielkema"
                    ),
                    new CommitteeMember(
                        1153,
                        "Kristel",
                        "Lok"
                    ),
                    new CommitteeMember(
                        1341,
                        "Joachim",
                        "Koojinga"
                    ),
                    new CommitteeMember(
                        1524,
                        "Chris",
                        "van Ewijk"
                    ),
                    new CommitteeMember(
                        1206,
                        "Max",
                        "Kamperman"
                    ),
                    new CommitteeMember(
                        1826,
                        "Robbert",
                        "Julius"
                    ),
            ],
            [
                "id" => 22,
                "title" => "Sympcie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Sympcie.jpg",
                "link" => "sympcie",
                "page" => "pages.association.committees.sympcie",
                "members" => [
                    new CommitteeMember(
                        1858,
                        "Eva",
                        "Visser"
                    ),
                    new CommitteeMember(
                        1140,
                        "Olivier",
                        "Gelling"
                    ),
                    new CommitteeMember(
                        1710,
                        "Bradley",
                        "Spronk"
                    ),
                    new CommitteeMember(
                        1776,
                        "Oscar",
                        "Tanis"
                    ),
                    new CommitteeMember(
                        1738,
                        "Jesse",
                        "Scheepstra"
                    ),
            ],
            [
                "id" => 28,
                "title" => "Takcie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Takcie.png",
                "link" => "takcie",
                "page" => null,
                "members" => [
                    new CommitteeMember(
                        1817,
                        "Emiel",
                        "de Wit"
                    ),
                    new CommitteeMember(
                        1786,
                        "Tamara",
                        "Kok"
                    ),
                    new CommitteeMember(
                        1880,
                        "Wim",
                        "Drenth"
                    ),
                    new CommitteeMember(
                        1858,
                        "Eva",
                        "Visser"
                    ),
                    new CommitteeMember(
                        1830,
                        "Aoibhin",
                        "Quinn"
                    ),
                    new CommitteeMember(
                        1733,
                        "Stijn",
                        "Eikens"
                    ),
            ],
            [
                "id" => 27,
                "title" => "Wiecksie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Wiecksie.png",
                "link" => "wiecksie",
                "page" => "pages.association.committees.wiecksie",
                "members" => [
                    new CommitteeMember(
                        1360,
                        "Pieter",
                        "Wolff"
                    ),
                    new CommitteeMember(
                        1710,
                        "Bradley",
                        "Spronk"
                    ),
                    new CommitteeMember(
                        1446,
                        "Rick",
                        "van Voorbergen"
                    ),
                    new CommitteeMember(
                        1293,
                        "Anton",
                        "Jansen"
                    ),
                    new CommitteeMember(
                        1361,
                        "Jelle",
                        "Bor"
                    ),
                    new CommitteeMember(
                        1556,
                        "Tom",
                        "Siebring"
                    ),
            ],
            [
                "id" => 4,
                "title" => "s[ck]rip(t|t?c)ie",
                "email" => "scriptcie@professorfrancken.nl",
                "logo" => "https://borrelcie.vodka/tmp/Scriptcie.png",
                "link" => "sckripttcie",
                "page" => "pages.association.committees.scriptcie",
                "members" => [
                    new CommitteeMember(
                        798,
                        "Paulus",
                        "Meessen"
                    ),
                    new CommitteeMember(
                        1403,
                        "Mark",
                        "Redeman"
                    ),
                    new CommitteeMember(
                        442,
                        "Gert",
                        "Eising"
                    ),
                    new CommitteeMember(
                        797,
                        "Sjoerd",
                        "Meesters"
                    ),
                    new CommitteeMember(
                        799,
                        "Sven",
                        "Baars"
                    ),
                    new CommitteeMember(
                        873,
                        "Mark",
                        "Boer"
                    ),
                ],
            ]
        ];

        $this->committees = array_map(
            function ($committee) {
                // Use faker to add some random members
                $faker = \App::make(\Faker\Generator::class);
                $faker->seed(31415);

                return new Committee(
                    $committee['id'],
                    $committee['title'],
                    $committee['email'],
                    $committee['logo'] ?? null,
                    $committee['link'],
                    $committee['page'],
                    $committee['members'] ?? array_map(function () use ($faker) {
                        return new CommitteeMember(
                            $faker->randomNumber,
                            $faker->firstName,
                            $faker->lastname
                        );
                    }, range(0, $faker->numberBetween(2, 6)))
                );
            },
            $this->committees
        );

        $this->committees = array_sort(
            $this->committees,
            function ($committee) {
                return $committee->name();
            }
        );
    }

    public function list() :  array
    {
        return $this->committees;
    }

    public function findByLink($link)
    {
        return array_first(
            array_filter(
                $this->committees,
                function ($committee) use ($link) {
                    return $committee->link() === $link;
                }
            )
        );
    }
}
