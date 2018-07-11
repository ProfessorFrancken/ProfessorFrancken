<?php

return [
    'menu' => [
        [
            'url' => '/study',
            'title' => 'Study',
            'subItems' => [
                ['url' => "/study/books", 'title' => 'Books'],
                ['url' => "/study/research-groups", 'title' => 'Research Groups'],
                ['url' => "/study/representation/university-council", 'title' => 'University Council'],
                ['url' => "/study/representation/faculty-council", 'title' => 'Faculty Council'],
            ],
            'icon' => 'graduation-cap',
        ],
        [
            'url' => '/association',
            'title' => 'Association',
            'subItems' => [
                ['url' => "/association/news", 'title' => 'News'],
                ['url' => "/association/history", 'title' => 'History'],
                ['url' => "/association/honorary-members", 'title' => 'Honorary members'],
                ['url' => "/association/boards", 'title' => 'Boards'],
                ['url' => "/association/committees", 'title' => 'Committees'],
                ['url' => "/association/francken-vrij", 'title' => 'Francken Vrij']
            ],
            //    'icon' => 'beer',
            'icon' => 'coffee',
        ],
        [
            'url' => '/career',
            'title' => 'Career',
            'subItems' => [
                ['url' => "/career/job-openings", 'title' => 'Job openings'],
                ['url' => "/career/companies", 'title' => 'Company profiles'],
                ['url' => "/career/events", 'title' => 'Career events']
            ],
            'icon' => 'suitcase',
        ],
        [
            'url' => 'https://www.flickr.com/photos/fotocie/sets/',
            'title' => 'Photos',
            'subItems' => [],
            'icon' => 'camera',
        ],
        [
            'url' => 'http://pienterkamp.nl/',
            'title' => 'Pienterkamp',
            'subItems' => [],
            'icon' => 'child'
        ],
    ],

    'admin-menu' => [
        [
            "name" => "Association",
            "url" => "association",
            "items" => [
                [
                    "name" => "News",
                    "url" => "news",
                    "works" => true,
                ],
                [
                    "name" => "Activities",
                    "url" => "activities",
                    "works" => false,
                ],
                [
                    "name" => "Open registrations",
                    "url" => "registration-requests",
                    "works" => true,
                ],
                [
                    "name" => "Members",
                    "url" => "members",
                    "works" => false,
                ],
                [
                    "name" => "Committees",
                    "url" => "committees",
                    "works" => false,
                ],
                [
                    "name" => "Francken Vrij",
                    "url" => "francken-vrij",
                    "works" => true,
                ],
            ]
        ],
        [
            "name" => "Study",
            "url" => "study",
            "items" => [
                [
                    "name" => "Research Groups",
                    "url" => "research-groups",
                    "works" => false,
                ],
                [
                    "name" => "Books",
                    "url" => "books",
                    "works" => false,
                ],
            ]
        ], [
            "name" => "Extern",
            "url" => "extern",
            "items" => [
                [
                    "name" => "Companies",
                    "url" => "companies",
                    "works" => false,
                ],
                [
                    "name" => "Events",
                    "url" => "events",
                    "works" => false,
                ],
                [
                    "name" => "Jop openings",
                    "url" => "jop-openings",
                    "works" => false,
                ],
                [
                    "name" => "Factsheet",
                    "url" => "fact-sheet",
                    "works" => true,
                ]
            ]
        ], [
            "name" => "Committees",
            "url" => "committees",
            "items" => [
                [
                    "name" => "Adtcie",
                    "url" => "adtcie",
                    "works" => false,
                ],
                [
                    "name" => "Borrelcie",
                    "url" => "borrelcie",
                    "works" => false,
                ],
                [
                    "name" => "Francken Vrij",
                    "url" => "francken-vrij",
                    "works" => false,
                ],
                [
                    "name" => "Brouwcie",
                    "url" => "brouwcie",
                    "works" => false,
                ],
                [
                    "name" => "Fotocie",
                    "url" => "fotocie",
                    "works" => false,
                ],
            ]
        ]
    ]
];
