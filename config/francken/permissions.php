<?php

declare(strict_types=1);

// policies, gate, permissions
return [
    'web' => [
        'super-admin-read',
        'super-admin-write',

        /**
         * These are permissions that should only be given to members having the
         * board role
         */
        'board',
        'board-president',
        'board-secretary',
        'board-treasurer',
        'board-external-relations',
        'board-internal-relations',

        'can-access-dashboard',

        'books-dashboard-read',
        'books-dashboard-write',

        'francken-vrij-read',
        'francken-vrij-write',

        'committees-read',
        'committees-write',
    ],

    'api' => [
    ]
];
