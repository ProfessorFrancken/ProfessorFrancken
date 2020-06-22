<?php

declare(strict_types=1);

return [
    'event_store_table' => 'event_store',

    'projectors' => [
        \Francken\Application\Committees\CommitteesListProjector::class,
    ],
];
