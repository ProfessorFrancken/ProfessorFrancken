<?php

declare(strict_types=1);

namespace Francken\Association\Boards;

use Illuminate\Support\Collection;

final class BoardsRepository
{
    public function all() : Collection
    {
        $boards = collect([
            [
                'year' => '2018-2019',
                'name' => 'Statisch',
                'members' => [
                    ['name' => 'Jeanne van Zuilen', 'title' => 'Commissioner of Internal Relations', 'photo' => '/images/boards/members/jeanne.jpg'],
                    ['name' => 'Chantal Kool', 'title' => 'Secretary and Vice-President', 'photo' => '/images/boards/members/chantal.jpg'],
                    ['name' => 'Joris Doting', 'title' => 'President', 'photo' => '/images/boards/members/joris.jpg'],
                    ['name' => 'Bradley Spronk', 'title' => 'Treasurer', 'photo' => '/images/boards/members/bradley.jpg'],
                    ['name' => 'Leon Trustram', 'title' => 'Commissioner of External Relations and Commissioner of Education', 'photo' => '/images/boards/members/leon.jpg']
                ],
                'figure' => 'https://professorfrancken.nl/images/boards/statisch.jpg',
                'figurePosition' => 'North'
            ],
            [
                'year' => '2017-2018',
                'name' => 'Hè Watt?',
                'members' => [
                    ['name' => 'Su-Elle Kamps', 'title' => 'Commissioner of Internal Relations and Vice-President', 'photo' => '/images/boards/members/su-elle.jpg'],
                    ['name' => 'Anna Kenbeek', 'title' => 'Secretary and Commissioner of Education', 'photo' => '/images/boards/members/anna.jpg'],
                    ['name' => 'Kathinka Frieswijk', 'title' => 'President', 'photo' => '/images/boards/members/kathinka-kat.jpg'],
                    ['name' => 'Arjen Kramer', 'title' => 'Treasurer', 'photo' => '/images/boards/members/arjen.jpg'],
                    ['name' => 'Mark Redeman', 'title' => 'Commissioner of External Relations', 'photo' => '/images/boards/members/mark.jpg']
                ],
                'figure' => 'https://professorfrancken.nl/images/boards/he_watt.jpg',
                'figurePosition' => ''
            ],
            [
                'year' => '2016-2017',
                'name' => 'Buitengewoon',
                'members' => [
                    ['name' => 'Willeke Mulder', 'title' => 'Secretary and Commissioner of Education'],
                    ['name' => 'Anton Jansen', 'title' => 'President'],
                    ['name' => 'David Koning', 'title' => 'Treasurer'],
                    ['name' => 'Anne in ‘t Veld', 'title' => 'Commissioner of External Relations and Vice-President']
                ],
                'figure' => 'https://professorfrancken.nl/images/header/board-buitengewoon.jpg',
                'figurePosition' => 'North'
            ],
            [
                'year' => '2015-2016',
                'name' => 'Daadkracht',
                'members' => [
                    ['name' => 'Max Kamperman', 'title' => 'Secretary and Commissioner of Education'],
                    ['name' => 'Jelle Bor', 'title' => 'President'],
                    ['name' => 'Evelien Zwanenburg', 'title' => 'Treasurer'],
                    ['name' => 'Pieter Wolff', 'title' => 'Commissioner of External Relations and Vice-President']
                ],
                'figure' => 'https://old.professorfrancken.nl/wordpress/media/images/besturen/bestuur_1516.JPG',
                'figurePosition' => ''
            ],
            [
                'year' => '2014-2015',
                'name' => 'Ingenieus',
                'members' => [
                    ['name' => 'Serte Donderwinkel', 'title' => 'Secretary and Vice-President'],
                    ['name' => 'Hilbert van Loo', 'title' => 'President'],
                    ['name' => 'Steven Groen', 'title' => 'Treasurer'],
                    ['name' => 'Friso Wobben', 'title' => 'Commissioner of External Relations']
                ],
                'figure' => 'https://old.professorfrancken.nl/wordpress/media/images/besturen/bestuur1415.jpg',
                'figurePosition' => 'North'
            ],
            [
                'year' => '2013-2014',
                'name' => 'Aantrekkingskracht',
                'members' => [
                    ['name' => 'Joran Böhmer', 'title' => 'Commissioner of External Relations and Vice-President'],
                    ['name' => 'Janneke Janssens', 'title' => 'Treasurer'],
                    ['name' => 'Paul Wijnbergen', 'title' => 'President'],
                    ['name' => 'Janna de Wit', 'title' => 'Secretary'],
                ],
                'figure' => 'https://old.professorfrancken.nl/wordpress/media/images/besturen/bestuur_1314_600breed.jpg',
                'figurePosition' => 'North'
            ],
            [
                'year' => '2012-2013',
                'name' => 'Binnenstebuiten',
                'members' => [
                    ['name' => 'Guus Winter', 'title' => 'Secretary'],
                    ['name' => 'Tom Bosma', 'title' => 'President'],
                    ['name' => 'Sjoerd Meesters', 'title' => 'Treasurer'],
                    ['name' => 'Bauke Steensma', 'title' => 'Commissioner of External Relations and Vice-President']
                ],
                'figure' => 'https://old.professorfrancken.nl/wordpress/media/images/besturen/bestuur_1213_600breed.jpg',
                'figurePosition' => 'North'
            ],
            [
                'year' => '2011-2012',
                'name' => 'Vooruit',
                'members' => [
                    ['name' => 'Maurits de Jong', 'title' => 'Secretary'],
                    ['name' => 'Tobias Van Damme', 'title' => 'Commissioner of External Relations and Vice-President'],
                    ['name' => 'Edwin de Jong', 'title' => 'President'],
                    ['name' => 'Marion Dam', 'title' => 'Treasurer'],
                ],
                'figure' => 'https://old.professorfrancken.nl/wordpress/media/images/besturen/bestuur_1112_600breed.png',
                'figurePosition' => 'North'
            ],
            [
                'year' => '2010-2011',
                'name' => 'Ruimte',
                'members' => [
                    ['name' => 'Marten Hutten', 'title' => 'Secretary'],
                    ['name' => 'Jasper Bosch', 'title' => 'President'],
                    ['name' => 'Hilbert Dijkstra', 'title' => 'Commissioner of External Relations and Vice-President'],
                    ['name' => 'Sjoerd Bielleman', 'title' => 'Treasurer'],
                ],
                'figure' => 'https://old.professorfrancken.nl/wordpress/media/images/besturen/bestuur_1011_600breed.png',
                'figurePosition' => ''
            ],
            [
                'year' => '2009-2010',
                'name' => 'Romeo Delta',
                'members' => [
                    ['name' => 'Arjan Bijlsma', 'title' => 'President'],
                    ['name' => 'Aernout van der Poel', 'title' => 'Treasurer'],
                    ['name' => 'Arjan Boerma', 'title' => 'Secretary'],
                    ['name' => 'Ypke Jager', 'title' => 'Commissioner of External Relations and Vice-President']
                ],
                'figure' => 'https://old.professorfrancken.nl/wordpress/media/images/besturen/bestuur_0910_600breed.jpg',
                'figurePosition' => 'North'
            ],
            [
                'year' => '2008-2009',
                'name' => 'Surreëel',
                'members' => [
                    ['name' => 'Mannold van der Schootbrugge', 'title' => 'President'],
                    ['name' => 'Victor Haverkort', 'title' => 'Treasurer'],
                    ['name' => 'Olger Zwier', 'title' => 'Commissioner of External Relations and Vice-President'],
                    ['name' => 'Thijs Huijskes', 'title' => 'Secretary'],
                ],
                'figure' => 'https://old.professorfrancken.nl/wordpress/media/images/besturen/bestuur_0809_600hoog.jpg',
                'figurePosition' => 'North'
            ],
            [
                'year' => '2007-2008',
                'name' => 'Smakeloos',
                'members' => [
                    ['name' => 'Jakko de Jong', 'title' => 'Commissioner of External Relations and Vice-President'],
                    ['name' => 'Laurens-Jan Soer', 'title' => 'Secretary'],
                    ['name' => 'Mark Schenkel', 'title' => 'President'],
                    ['name' => 'Pelle Koeslag', 'title' => 'Treasurer'],
                ],
                'figure' => 'https://old.professorfrancken.nl/wordpress/media/images/besturen/bestuur_0708_600breed.jpg',
                'figurePosition' => 'North'
            ],
            [
                'year' => '2006-2007',
                'name' => 'Vanzulf',
                'members' => [
                    ['name' => 'Jasper van den Berg', 'title' => 'Treasurer'],
                    ['name' => 'Rudy Schuitema', 'title' => 'President'],
                    ['name' => 'Tom de Boer', 'title' => 'Commissioner of External Relations and Vice-President'],
                    ['name' => 'Sander Boonstra', 'title' => 'Secretary'],
                ],
                'figure' => 'https://old.professorfrancken.nl/wordpress/media/images/besturen/bestuur_0607_600breed.jpg',
                'figurePosition' => 'North'
            ],
            [
                'year' => '2005-2006',
                'name' => '',
                'members' => [
                    ['name' => 'Wendy Docters', 'title' => 'Secretary'],
                    ['name' => 'Christiaan van der Kwaak', 'title' => 'President'],
                    ['name' => 'Reeuwerd Straatman', 'title' => 'Treasurer'],
                    ['name' => 'Tom Boot', 'title' => 'Commissioner of External Relations and Vice-President']
                ],
                'figure' => 'https://old.professorfrancken.nl/wordpress/media/images/besturen/bestuur_0506_600breed.jpg',
                'figurePosition' => 'North'
            ],
            [
                'year' => '2004-2005',
                'name' => '',
                'members' => [
                    ['name' => 'Gerbert Bakker', 'title' => 'President'],
                    ['name' => 'Sander Onur', 'title' => 'Commissioner of External Relations and Vice-President'],
                    ['name' => 'Arjan van der Pal', 'title' => 'Treasurer'],
                    ['name' => 'Bas Vlaming', 'title' => 'Secretary'],
                ],
                'figure' => 'https://old.professorfrancken.nl/wordpress/media/images/besturen/bestuur_0405_600breed.jpg',
                'figurePosition' => 'North'
            ],
            [
                'year' => '2003-2004',
                'name' => '',
                'members' => [
                    ['name' => 'Teun Koeman', 'title' => 'Treasurer'],
                    ['name' => 'Hedde van Hoorn', 'title' => 'Commissioner of External Relations and Vice-President'],
                    ['name' => 'Marc de Boer', 'title' => 'President'],
                    ['name' => 'Maaike Wiltjer', 'title' => 'Secretary'],
                ],
                'figure' => 'https://old.professorfrancken.nl/wordpress/media/images/besturen/bestuur_0304_640breed.jpg',
                'figurePosition' => ''
            ],
            [
                'year' => '2002-2003',
                'name' => '',
                'members' => [
                    ['name' => 'Auke-Siûk Nutma', 'title' => 'Commissioner of External Relations and Vice-President'],
                    ['name' => 'Dennis Westra', 'title' => 'Secretary'],
                    ['name' => 'Timon Lely', 'title' => 'Treasurer'],
                    ['name' => 'Marten Frantzen', 'title' => 'President'],
                ],
                'figure' => 'https://old.professorfrancken.nl/wordpress/media/images/besturen/bestuur_0203_600breed.jpg',
                'figurePosition' => ''
            ],
            [
                'year' => '2001-2002',
                'name' => '',
                'members' => [
                    ['name' => 'Marloes Steneker', 'title' => 'President'],
                    ['name' => 'Herman Nicolai', 'title' => 'Secretary'],
                    ['name' => 'Peter Koopmans', 'title' => 'Treasurer'],
                    ['name' => 'Reinier Kaptein', 'title' => 'Commissioner of External Relations and Vice-President']
                ],
                'figure' => '',
                'figurePosition' => ''
            ],
            [
                'year' => '2000-2001',
                'name' => '',
                'members' => [
                    ['name' => 'Erik Koop', 'title' => 'Commissioner of External Relations and Vice-President'],
                    ['name' => 'Tasco Silva', 'title' => 'Secretary'],
                    ['name' => 'Chris Rademakers', 'title' => 'President and Treasurer'],
                ],
                'figure' => 'https://old.professorfrancken.nl/wordpress/media/images/besturen/bestuur_0001_600breed.jpg',
                'figurePosition' => 'North'
            ],
            [
                'year' => '1999-2000',
                'name' => '',
                'members' => [
                    ['name' => 'Ramon van Ingen', 'title' => 'President'],
                    ['name' => 'Dirk Bekke', 'title' => 'Secretary'],
                    ['name' => 'Wouter van Strien', 'title' => 'Treasurer'],
                    ['name' => 'Laurens Willem van Beveren', 'title' => 'Commissioner of External Relations and Vice-President']
                ],
                'figure' => '',
                'figurePosition' => ''
            ],
            [
                'year' => '1998-1999',
                'name' => '',
                'members' => [
                    ['name' => 'Sander Nijman', 'title' => 'President'],
                    ['name' => 'Wouter Soer', 'title' => 'Secretary'],
                    ['name' => 'Jur de Vries', 'title' => 'Treasurer'],
                    ['name' => 'Armand van der Veen', 'title' => 'Commissioner of External Relations and Vice-President']
                ],
                'figure' => '',
                'figurePosition' => ''
            ],
            [
                'year' => '1997-1998',
                'name' => '',
                'members' => [
                    ['name' => 'Frank Meijer', 'title' => 'President'],
                    ['name' => 'Rutger van Merkerk', 'title' => 'Secretary'],
                    ['name' => 'Victor van Heeswijk', 'title' => 'Treasurer'],
                    ['name' => 'Ronald Hanson', 'title' => 'Commissioner of External Relations and Vice-President']
                ],
                'figure' => '',
                'figurePosition' => ''
            ],
            [
                'year' => '1996-1997',
                'name' => '',
                'members' => [
                    ['name' => 'Sjoerd Blom', 'title' => 'President'],
                    ['name' => 'Jan-Willem Berghuis', 'title' => 'Secretary'],
                    ['name' => 'Eric van de Schoot', 'title' => 'Treasurer'],
                    ['name' => 'Bouke Hoving', 'title' => 'Commissioner of External Relations and Vice-President']
                ],
                'figure' => '',
                'figurePosition' => ''
            ],
            [
                'year' => '1995-1996',
                'name' => '',
                'members' => [
                    ['name' => 'Maarten Stokhof', 'title' => 'President'],
                    ['name' => 'Lars de Groot', 'title' => 'Secretary'],
                    ['name' => 'Jeroen de Boer', 'title' => 'Treasurer'],
                    ['name' => 'Frederick Meis', 'title' => 'Commissioner of External Relations and Vice-President'],
                    ['name' => 'Marc Gotink', 'title' => 'Commissioner of External Relations and Vice-President']],
                'figure' => '',
                'figurePosition' => ''
            ],
            [
                'year' => '1994-1995',
                'name' => '',
                'members' => [
                    ['name' => 'Frans Venker', 'title' => 'President'],
                    ['name' => 'Walter Ganzevles', 'title' => 'Secretary'],
                    ['name' => 'Marieke Duijvestein', 'title' => 'Treasurer'],
                    ['name' => 'Robert-Jan Zandvoort', 'title' => 'Commissioner of External Relations and Vice-President']],
                'figure' => '',
                'figurePosition' => ''
            ],
            [
                'year' => '1993-1994',
                'name' => '',
                'members' => [
                    ['name' => 'Marlien Klijnstra', 'title' => 'President'],
                    ['name' => 'Alex Schoonveld', 'title' => 'Secretary'],
                    ['name' => 'Klaas Jan Wieringa', 'title' => 'Treasurer']],
                'figure' => '',
                'figurePosition' => ''
            ],
            [
                'year' => '1992-1993',
                'name' => '',
                'members' => [
                    ['name' => 'Sander Tichelaar', 'title' => 'President'],
                    ['name' => 'Marco Workel', 'title' => 'Secretary'],
                    ['name' => 'Robin Advokaat', 'title' => 'Treasurer']],
                'figure' => '',
                'figurePosition' => ''
            ],
            [
                'year' => '1991-1992',
                'name' => '',
                'members' => [
                    ['name' => 'Jorgen van der Velde', 'title' => 'President'],
                    ['name' => 'Ruerd Heeg', 'title' => 'Secretary'],
                    ['name' => 'Maarten van Essen', 'title' => 'Treasurer']],
                'figure' => '',
                'figurePosition' => ''
            ],
            [
                'year' => '1990-1991',
                'name' => '',
                'members' => [
                    ['name' => 'Arjan Douwes', 'title' => 'President'],
                    ['name' => 'Nico van der Post', 'title' => 'Secretary'],
                    ['name' => 'Peter Magnee', 'title' => 'Treasurer']],
                'figure' => '',
                'figurePosition' => ''
            ],
            [
                'year' => '1989-1990',
                'name' => '',
                'members' => [
                    ['name' => 'Wouter de Vries', 'title' => 'President'],
                    ['name' => 'Sybren Sijbrandij', 'title' => 'Secretary'],
                    ['name' => 'Hung Le', 'title' => 'Treasurer']],
                'figure' => '',
                'figurePosition' => ''
            ],
            [
                'year' => '1988-1989',
                'name' => '',
                'members' => [
                    ['name' => 'Dirk van Dijk', 'title' => 'President'],
                    ['name' => 'Erik Lukkien', 'title' => 'Secretary'],
                    ['name' => 'Menno van der Burg', 'title' => 'Treasurer']],
                'figure' => '',
                'figurePosition' => ''
            ],
            [
                'year' => '1987-1988',
                'name' => '',
                'members' => [
                    ['name' => 'Erik Dalhuijsen', 'title' => 'President'],
                    ['name' => 'Peter Reijneker', 'title' => 'Secretary'],
                    ['name' => 'Gerritjan Wessels', 'title' => 'Treasurer']],
                'figure' => '',
                'figurePosition' => ''
            ],
            [
                'year' => '1986-1987',
                'name' => '',
                'members' => [
                    ['name' => 'Pim Luiten', 'title' => 'President'],
                    ['name' => 'Wenzel Hurtak', 'title' => 'Secretary till 1 July'],
                    ['name' => 'Peter Reijneker', 'title' => 'Secretary from 1 July'],
                    ['name' => 'Pieter Simon van Dijk', 'title' => 'Treasurer']],
                'figure' => '',
                'figurePosition' => ''
            ],
            [
                'year' => '1984-1986',
                'name' => '',
                'members' => [
                    ['name' => 'Tom Franke', 'title' => 'President'],
                    ['name' => 'Guustaaf Brouwer', 'title' => 'Secretary'],
                    ['name' => 'Pieter Simon van Dijk', 'title' => 'Treasurer']],
                'figure' => '',
                'figurePosition' => ''
            ],
        ]);

        $boards = $boards->map(function ($board) {
            $board_year = BoardYear::fromString($board['year']);
            $members = collect($board['members']);

            $board = new Board([
                'name' => $board['name'],
                'photo' => $board['figure'],
                'photo_position' => $board['figurePosition'],
                'installed_at' => $board_year->start(),
                'decharged_at' => $board_year->end(),
            ]);
            $board->id = 1;
            $board->members = $members->map(function ($member) use ($board_year) {
                return new BoardMember([
                        'name' => $member['name'],
                        'title' => $member['title'],
                        'photo' => $member['photo'] ?? null,
                        'installed_at' => $board_year->start(),
                        'decharged_at' => $board_year->end(),
                    ]);
            });
            return $board;
        });

        return $boards;
    }

    public function find($board_id) : Board
    {
    }

    public function save(Board $board) : void
    {
    }

    public function boardDuringDate(DateTimeImmutable $date) : Board
    {
    }
}
