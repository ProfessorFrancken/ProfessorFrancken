<?php

declare(strict_types=1);

namespace Francken\Association\Committees;

use Francken\Shared\AcademicYear;
use Francken\Association\Committees\HardcodedCommittee;
use Francken\Association\Committees\HardcodedCommitteeMember;

final class HardcodedCommitteesRepository
{
    private $committees;

    public function __construct()
    {
        $this->committees = [
            [
                "id" => 111,
                "title" => "Adtcie",
                "email" => "",
                "logo" => "",
                "link" => "adtcie",
                "page" => "pages.association.committees.adtcie",
                "members" => [
                ],
            ],
            [
                "id" => 35,
                "title" => "Alumnicie",
                "email" => "alumni@professorfrancken.nl",
                "logo" => "https://professorfrancken.nl/images/committees/Alumnicie.png",
                "link" => "alumnicie",
                "page" => "pages.association.committees.alumnicie",
                "members" => [
                ],
            ],
            [
                "id" => 407,
                "title" => "Almanakcie",
                "email" => "almanakfrancken@gmail.com",
                "logo" => "",
                "link" => "almanakcie",
                "page" => "pages.association.committees.almanakcie",
                "members" => [
                ],
            ],
            // [
            //     "id" => 404,
            //     "title" => "Bincie",
            //     "email" => "",
            //     "logo" => "https://professorfrancken.nl/images/committees/Bincie.png",
            //     "link" => "bincie",
            //     "page" => "pages.association.committees.bincie",
            // ],
            [
                "id" => 19,
                "title" => "Borrelcie",
                "email" => "",
                "logo" => "https://professorfrancken.nl/images/committees/Borrelcie.png",
                "link" => "borrelcie",
                "page" => "pages.association.committees.borrelcie",
                "members" => [
                ],
            ],
            [
                "id" => 33,
                "title" => "Brouwcie",
                "email" => "",
                "logo" => "https://professorfrancken.nl/images/committees/Brouwcie.png",
                "link" => "brouwcie",
                "page" => "pages.association.committees.brouwcie",
                "members" => [
                ],
            ],
            [
                "id" => 2,
                "title" => "Buixie",
                "email" => "",
                "logo" => "https://professorfrancken.nl/images/committees/Buixie.png",
                "link" => "buixie",
                "page" => "pages.association.committees.buixie",
                "members" => [
                ],
            ],
            // [
            //     "id" => 53,
            //     "title" => "CoDcie",
            //     "email" => "",
            //     "logo" => "https://professorfrancken.nl/images/committees/CoDcie.png",
            //     "link" => "codcie",
            //     "page" => "pages.association.committees.codcie",
            // ],
            [
                "id" => 1,
                "title" => "Compucie",
                "email" => "",
                "logo" => "https://professorfrancken.nl/images/committees/Compucie.png",
                "link" => "compucie",
                "page" => "pages.association.committees.compucie",
                "members" => [
                ],
            ],
            [
                "id" => 21,
                "title" => "Fotocie",
                "email" => "",
                "logo" => "https://professorfrancken.nl/images/committees/Fotocie.png",
                "link" => "fotocie",
                "page" => "pages.association.committees.fotocie",
                "members" => [
                ],
            ],
            [
                "id" => 9,
                "title" => "Fraccie",
                "email" => "Fraccie@professorfrancken.nl",
                "logo" => "https://professorfrancken.nl/images/committees/Fraccie.png",
                "link" => "fraccie",
                "page" => "pages.association.committees.fraccie",
                "members" => [
                ],
            ],
            [
                "id" => 10,
                "title" => "Francken Vrij",
                "email" => "",
                "logo" => "https://professorfrancken.nl/images/committees/Francken_Vrij.png",
                "link" => "francken-vrij",
                "page" => "pages.association.committees.francken-vrij",
                "members" => [
                ],
            ],
            [
                "id" => 32,
                "title" => "Intercie",
                "email" => "",
                "logo" => "https://professorfrancken.nl/images/committees/Intercie.png",
                "link" => "intercie",
                "page" => null,
                "members" => [
                ],
            ],
            [
                "id" => 12,
                "title" => "Kascie",
                "email" => "",
                "logo" => "https://professorfrancken.nl/images/committees/Kascie.png",
                "link" => "kascie",
                "page" => "pages.association.committees.kascie",
                "members" => [
                ],
            ],
            [
                "id" => 18,
                "title" => "Oefensescie",
                "email" => "",
                "logo" => "https://professorfrancken.nl/images/committees/Oefensescie.png",
                "link" => "oefensescie",
                "page" => "pages.association.committees.oefensescie",
                "members" => [
                ],
            ],
            [
                "id" => 5,
                "title" => "Representacie",
                "email" => "",
                "logo" => "https://professorfrancken.nl/images/committees/Representacie.png",
                "link" => "representacie",
                "page" => "pages.association.committees.representacie",
                "members" => [
                ],
            ],
            [
                "id" => 24,
                "title" => "Sjaarscie",
                "email" => "",
                "logo" => "https://professorfrancken.nl/images/committees/Sjaarscie.png",
                "link" => "sjaarscie",
                "page" => "pages.association.committees.sjaarcie",
                "members" => [
                ],
            ],
            [
                "id" => 29,
                "title" => "Sportcie",
                "email" => "",
                "logo" => "https://professorfrancken.nl/images/committees/Sportcie.png",
                "link" => "sportcie",
                "page" => null,
                "members" => [
                ],
            ],
            [
                "id" => 22,
                "title" => "Sympcie",
                "email" => "",
                "logo" => "https://professorfrancken.nl/images/committees/symposium-2019.png",
                "link" => "sympcie",
                "page" => "pages.association.committees.sympcie",
                "members" => [
                ],
            ],
            [
                "id" => 28,
                "title" => "Takcie",
                "email" => "",
                "logo" => "https://professorfrancken.nl/images/committees/Takcie.png",
                "link" => "takcie",
                "page" => null,
                "members" => [
                ],
            ],
            [
                "id" => 27,
                "title" => "Wiecksie",
                "email" => "",
                "logo" => "https://professorfrancken.nl/images/committees/Wiecksie.png",
                "link" => "wiecksie",
                "page" => "pages.association.committees.wiecksie",
                "members" => [
                ],
            ],
            [
                "id" => 4,
                "title" => "s[ck]rip(t|t?c)ie",
                "email" => "scriptcie@professorfrancken.nl",
                "logo" => "https://professorfrancken.nl/images/committees/Scriptcie.png",
                "link" => "sckripttcie",
                "page" => "pages.association.committees.scriptcie",
                "members" => [
                ],
            ]
        ];


        $this->committees = array_map(
            function ($committee) {
                return new HardcodedCommittee(
                    $committee['id'],
                    $committee['title'],
                    $committee['email'],
                    $committee['logo'] ?? null,
                    $committee['link'],
                    $committee['page'],
                    []
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

    public function list() : array
    {
        return $this->committees;
    }

    public function findByLink($link)
    {
        $committee = array_first(
            array_filter(
                $this->committees,
                function ($committee) use ($link) {
                    return $committee->link() === $link;
                }
            )
        );

        $today = new \DateTimeImmutable();
        $year = AcademicYear::fromDate($today);

        $members = \DB::connection('francken-legacy')
            ->table('commissie_lid')
            ->select(['leden.id', 'leden.voornaam', 'leden.tussenvoegsel', 'leden.achternaam'])
            ->join('leden', 'leden.id', 'commissie_lid.lid_id')
            ->where('jaar', $year->start()->format('Y'))
            ->where('commissie_id', $committee->id())
            ->get()
            ->map(function ($member) {
                return new HardcodedCommitteeMember(
                    $member->id,
                    implode(' ', array_filter([$member->voornaam, $member->tussenvoegsel, $member->achternaam]))
                );
            });

        return new HardcodedCommittee(
            $committee->id(),
            $committee->name(),
            $committee->email(),
            $committee->logo(),
            $committee->link(),
            $committee->page(),
            $members->toArray()
        );
    }

    public function ofMember(int $franckenMemberId) : array
    {
        $today = new \DateTimeImmutable();
        $year = AcademicYear::fromDate($today);

        $committees = \DB::connection('francken-legacy')
            ->table('commissie_lid')
            ->select(['commissie_id', 'functie', 'jaar'])
            ->where('jaar', $year->start()->format('Y'))
            ->where('lid_id', $franckenMemberId)
            ->get();

        return array_filter(
            $this->committees,
            function ($committee) use ($committees) {
                return $committees->map(
                    function ($committee) {
                        return $committee->commissie_id;
                    }
                )->contains($committee->id());
            }
        );
    }
}
