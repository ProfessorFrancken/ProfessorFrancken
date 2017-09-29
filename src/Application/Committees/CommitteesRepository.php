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
                        1746,
                        "Bo",
                        "Gruppen"
                    ),
                    new CommitteeMember(
                        1372,
                        "Ids",
                        "Schiere"
                    ),
                    new CommitteeMember(
                        1670,
                        "Mees",
                        "Hoogland"
                    ),
                    new CommitteeMember(
                        1710,
                        "Bradley",
                        "Spronk"
                    ),
                    new CommitteeMember(
                        1163,
                        "Willeke",
                        "Mulder"
                    ),
                ]
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
            [
                "id" => 2,
                "title" => "Buixie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Buixie.png",
                "link" => "buixie",
                "page" => "pages.association.committees.buixie",
                "members" => [
                    new CommitteeMember(
                        1143,
                        "Willeke",
                        "Mulder"
                    ),
                    new CommitteeMember(
                        1582,
                        "Joris",
                        "Doting"
                    ),
                    new CommitteeMember(
                        1174,
                        "David",
                        "Koning"
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
                ]
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
                        1187,
                        "Jasper",
                        "Staal"
                    ),
                    new CommitteeMember(
                        1760,
                        "Jeanne",
                        "van Zuilen"
                    ),
                    new CommitteeMember(
                        1608,
                        "Su-Elle",
                        "Kamps"
                    ),
                    new CommitteeMember(
                        692,
                        "Edwin",
                        "de Jong"
                    ),
                    new CommitteeMember(
                        1817,
                        "Emiel",
                        "de Wit"
                    ),
                ]
            ],
            [
                "id" => 9,
                "title" => "Fraccie",
                "email" => "Fraccie@professorfrancken.nl",
                "logo" => "https://borrelcie.vodka/tmp/Fraccie.png",
                "link" => "fraccie",
                "page" => "pages.association.committees.fraccie",
                "members" => [
                    new CommitteeMember(
                        1209,
                        "Laurens",
                        "Even"
                    ),
                    new CommitteeMember(
                        1774,
                        "Alida",
                        "Hunnink"
                    ),
                    new CommitteeMember(
                        1760,
                        "Jeanne",
                        "van Zuilen"
                    ),
                    new CommitteeMember(
                        1786,
                        "Tamara",
                        "Kok"
                    ),
                    new CommitteeMember(
                        1732,
                        "Puck",
                        "Planje"
                    ),
                ]
            ],
            [
                "id" => 10,
                "title" => "Francken Vrij",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Francken_Vrij.png",
                "link" => "francken-vrij",
                "page" => "pages.association.committees.francken-vrij",
            ],
            [
                "id" => 32,
                "title" => "Intercie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Intercie.png",
                "link" => "intercie",
                "page" => null,
            ],
            [
                "id" => 12,
                "title" => "Kascie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Kascie.png",
                "link" => "kascie",
                "page" => "pages.association.committees.kascie",
            ],
            [
                "id" => 18,
                "title" => "Oefensescie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Oefensescie.png",
                "link" => "oefensescie",
                "page" => "pages.association.committees.oefensescie",
            ],
            [
                "id" => 5,
                "title" => "Representacie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Representacie.png",
                "link" => "representacie",
                "page" => "pages.association.committees.representacie",
            ],
            [
                "id" => 24,
                "title" => "Sjaarscie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Sjaarscie.png",
                "link" => "sjaarscie",
                "page" => "pages.association.committees.sjaarcie",
            ],
            [
                "id" => 29,
                "title" => "Sportcie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Sportcie.png",
                "link" => "sportcie",
                "page" => null,
            ],
            [
                "id" => 22,
                "title" => "Sympcie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Sympcie.jpg",
                "link" => "sympcie",
                "page" => "pages.association.committees.sympcie",
            ],
            [
                "id" => 28,
                "title" => "Takcie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Takcie.png",
                "link" => "takcie",
                "page" => null,
            ],
            [
                "id" => 27,
                "title" => "Wiecksie",
                "email" => "",
                "logo" => "https://borrelcie.vodka/tmp/Wiecksie.png",
                "link" => "wiecksie",
                "page" => "pages.association.committees.wiecksie",
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
                    $committee['members'] ?? []
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
