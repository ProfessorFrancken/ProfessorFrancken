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
                "link" => "alumnicie",
                "page" => "pages.association.committees.alumnicie",
            ],
            [
                "id" => 19,
                "title" => "Borrelcie",
                "email" => "",
                "logo" => "http://borrelcie.vodka/img/borrelcielogo.png",
                "link" => "borrelcie",
                "page" => "pages.association.committees.borrelcie",
            ],
            [
                "id" => 33,
                "title" => "Brouwcie",
                "email" => "",
                "link" => "brouwcie",
                "page" => "pages.association.committees.brouwcie",
            ],
            [
                "id" => 2,
                "title" => "Buixie",
                "email" => "",
                "link" => "buixie",
                "page" => "pages.association.committees.buixie",
            ],
            [
                "id" => 53,
                "title" => "CoDcie",
                "email" => "",
                "link" => "codcie",
                "page" => "pages.association.committees.codcie",
            ],
            [
                "id" => 1,
                "title" => "Compucie",
                "email" => "",
                "link" => "compucie",
                "page" => "pages.association.committees.compucie",
            ],
            [
                "id" => 21,
                "title" => "Fotocie",
                "email" => "",
                "link" => "fotocie",
                "page" => "pages.association.committees.fotocie",
            ],
            [
                "id" => 9,
                "title" => "Fraccie",
                "email" => "",
                "link" => "fraccie",
                "page" => "pages.association.committees.fraccie",
            ],
            [
                "id" => 10,
                "title" => "Francken Vrij",
                "email" => "",
                "link" => "francken-vrij",
                "page" => "pages.association.committees.francken-vrij",
            ],
            [
                "id" => 32,
                "title" => "Intercie",
                "email" => "",
                "link" => "intercie",
                "page" => null,
            ],
            [
                "id" => 12,
                "title" => "Kascie",
                "email" => "",
                "link" => "kascie",
                "page" => "pages.association.committees.kascie",
            ],
            [
                "id" => 18,
                "title" => "Oefensescie",
                "email" => "",
                "link" => "oefensescie",
                "page" => "pages.association.committees.oefensescie",
            ],
            [
                "id" => 5,
                "title" => "Representacie",
                "email" => "",
                "link" => "representacie",
                "page" => "pages.association.committees.representacie",
            ],
            [
                "id" => 24,
                "title" => "Sjaarscie",
                "email" => "",
                "link" => "sjaarscie",
                "page" => "pages.association.committees.sjaarcie",
            ],
            [
                "id" => 29,
                "title" => "Sportcie",
                "email" => "",
                "link" => "sportcie",
                "page" => null,
            ],
            [
                "id" => 22,
                "title" => "Sympcie",
                "email" => "",
                "link" => "sympcie",
                "page" => "pages.association.committees.sympcie",
            ],
            [
                "id" => 28,
                "title" => "Takcie",
                "email" => "",
                "link" => "takcie",
                "page" => null,
            ],
            [
                "id" => 27,
                "title" => "Wiecksie",
                "email" => "",
                "link" => "wiecksie",
                "page" => "pages.association.committees.wiecksie",
            ],
            [
                "id" => 4,
                "title" => "s[ck]rip(t|t?c)ie",
                "email" => "scriptcie@professorfrancken.nl",
                "link" => "sckripttcie",
                "page" => "pages.association.committees.scriptcie",
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
                    array_map(function () use ($faker) {
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
