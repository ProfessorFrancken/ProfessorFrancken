<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers;

final class CommitteesController
{
    public function __construct()
    {
        $this->committees = $this->load();
    }

    public function index()
    {
        $committees = $this->load();

        return view('committees.index')
            ->with('committees', $committees);
    }

    public function show($link)
    {
        $committee = array_first(
            array_filter(
                $this->load(),
                function ($committee) use ($link) {
                    return $committee['link'] === $link;
                }
            )
        );

        if (! is_null($committee['page'])) {
            return view($committee['page'])
                ->with('committee', $committee)
                ->with('committees', $this->load());
        }

        return view('committees.show')
            ->with('committee', $committee)
            ->with('committees', $this->load());
    }

    private function load()
    {
        $committees = [
            [
                "id" => 35,
                "title" => "Alumnicie",
                "email" => "alumni@professorfrancken.nl",
                "logo" => "https://api.adorable.io/avatars/75/35.png",
                "description" => "",
                "translated" => "",
                "link" => "alumnicie",
                "page" => "pages.association.committees.alumnicie",
                "years" => ["2016" => []]
            ],
            [
                "id" => 19,
                "title" => "Borrelcie",
                "email" => "",
                "logo" => "http://borrelcie.vodka/img/borrelcielogo.png",
                "description" => "",
                "translated" => "",
                "link" => "borrelcie",
                "page" => "pages.association.committees.borrelcie",
                "years" => [
                    "2016" => [
                    ]
                ]
            ],
            [
                "id" => 33,
                "title" => "Brouwcie",
                "email" => "",
                "logo" => "https://api.adorable.io/avatars/75/33.png",
                "description" => "",
                "translated" => "",
                "link" => "brouwcie",
                "page" => "pages.association.committees.brouwcie",
                "years" => [
                    "2016" => [
                    ]
                ]
            ],
            [
                "id" => 2,
                "title" => "Buixie",
                "email" => "",
                "logo" => "https://api.adorable.io/avatars/75/2.png",
                "description" => "",
                "translated" => "",
                "link" => "buixie",
                "page" => "pages.association.committees.buixie",
                "years" => [
                    "2016" => [
                    ]
                ]
            ],
            [
                "id" => 53,
                "title" => "CoDcie",
                "email" => "",
                "logo" => "https://api.adorable.io/avatars/75/53.png",
                "description" => "",
                "translated" => "",
                "link" => "codcie",
                "page" => "pages.association.committees.codcie",
                "years" => [
                    "2016" => [
                    ]
                ]
            ],
            [
                "id" => 1,
                "title" => "Compucie",
                "email" => "",
                "logo" => "https://api.adorable.io/avatars/75/1.png",
                "description" => "",
                "translated" => "",
                "link" => "compucie",
                "page" => "pages.association.committees.compucie",
                "years" => [
                    "2016" => [
                    ]
                ]
            ],
            [
                "id" => 21,
                "title" => "Fotocie",
                "email" => "",
                "logo" => "https://api.adorable.io/avatars/75/21.png",
                "description" => "",
                "translated" => "",
                "link" => "fotocie",
                "page" => "pages.association.committees.fotocie",
                "years" => [
                    "2016" => [
                    ]
                ]
            ],
            [
                "id" => 9,
                "title" => "Fraccie",
                "email" => "",
                "logo" => "https://api.adorable.io/avatars/75/9.png",
                "description" => "",
                "translated" => "",
                "link" => "fraccie",
                "page" => "pages.association.committees.fraccie",
                "years" => [
                    "2016" => [
                    ]
                ]
            ],
            [
                "id" => 10,
                "title" => "Francken Vrij",
                "email" => "",
                "logo" => "https://api.adorable.io/avatars/75/10.png",
                "description" => "",
                "translated" => "",
                "link" => "francken-vrij",
                "page" => "pages.association.committees.francken-vrij",
                "years" => [
                    "2016" => [
                    ]
                ]
            ],
            [
                "id" => 32,
                "title" => "Intercie",
                "email" => "",
                "logo" => "https://api.adorable.io/avatars/75/32.png",
                "description" => "",
                "translated" => "",
                "link" => "intercie",
                "page" => null,
                "years" => [
                    "2016" => [
                    ]
                ]
            ],
            [
                "id" => 12,
                "title" => "Kascie",
                "email" => "",
                "logo" => "https://api.adorable.io/avatars/75/12.png",
                "description" => "",
                "translated" => "",
                "link" => "kascie",
                "page" => "pages.association.committees.kascie",
                "years" => [
                    "2016" => [
                    ]
                ]
            ],
            [
                "id" => 18,
                "title" => "Oefensescie",
                "email" => "",
                "logo" => "https://api.adorable.io/avatars/75/18.png",
                "description" => "",
                "translated" => "",
                "link" => "oefensescie",
                "page" => "pages.association.committees.oefensescie",
                "years" => [
                    "2016" => [
                    ]
                ]
            ],
            [
                "id" => 5,
                "title" => "Representacie",
                "email" => "",
                "logo" => "https://api.adorable.io/avatars/75/5.png",
                "description" => "",
                "translated" => "",
                "link" => "representacie",
                "page" => "pages.association.committees.representacie",
                "years" => [
                    "2016" => [
                    ]
                ]
            ],
            [
                "id" => 24,
                "title" => "Sjaarscie",
                "email" => "",
                "logo" => "https://api.adorable.io/avatars/75/24.png",
                "description" => "",
                "translated" => "",
                "link" => "sjaarscie",
                "page" => "pages.association.committees.sjaarcie",
                "years" => [
                    "2016" => [
                    ]
                ]
            ],
            [
                "id" => 29,
                "title" => "Sportcie",
                "email" => "",
                "logo" => "https://api.adorable.io/avatars/75/29.png",
                "description" => "",
                "translated" => "",
                "link" => "sportcie",
                "page" => null,
                "years" => [
                    "2016" => [
                    ]
                ]
            ],
            [
                "id" => 22,
                "title" => "Sympcie",
                "email" => "",
                "logo" => "https://api.adorable.io/avatars/75/22.png",
                "description" => "",
                "translated" => "",
                "link" => "sympcie",
                "page" => "pages.association.committees.sympcie",
                "years" => [
                    "2016" => [
                    ]
                ]
            ],
            [
                "id" => 28,
                "title" => "Takcie",
                "email" => "",
                "logo" => "https://api.adorable.io/avatars/75/28.png",
                "description" => "",
                "translated" => "",
                "link" => "takcie",
                "page" => null,
                "years" => [
                    "2016" => [
                    ]
                ]
            ],
            [
                "id" => 27,
                "title" => "Wiecksie",
                "email" => "",
                "logo" => "https://api.adorable.io/avatars/75/27.png",
                "description" => "",
                "translated" => "",
                "link" => "wiecksie",
                "page" => "pages.association.committees.wiecksie",
                "years" => [
                    "2016" => [
                    ]
                ]
            ],
            [
                "id" => 4,
                "title" => "s[ck]rip(t|t?c)ie",
                "email" => "scriptcie@professorfrancken.nl",
                "logo" => "https://api.adorable.io/avatars/75/4.png",
                "description" => "",
                "translated" => "",
                "link" => "sckripttcie",
                "page" => "pages.association.committees.scriptcie",
                "years" => [
                    "2016" => [
                    ]
                ]
            ]
        ];

        // Use faker to add some random members
        $faker = \App::make(\Faker\Generator::class);
        $faker->seed(31415);

        foreach ($committees as &$committee) {
            $members = array_map(function () use ($faker) {
                return [
                    'id' => $faker->randomNumber,
                    'firstname' => $faker->firstName,
                    'surname' => $faker->lastname,
                    'email' => $faker->email,
                    'created_at' => $faker->dateTime->format('Y-m-d H:i:s')
                ];
            }, range(0, $faker->numberBetween(2, 6)));
            $committee['years']['2016'] = $members;
        }

        return $committees;
    }
}
