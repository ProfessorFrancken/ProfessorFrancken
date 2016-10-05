<?php

return [
    'event_store_table' => 'event_store',

    'projectors' => [
        \Francken\Application\Committees\CommitteesListProjector::class,
        \Francken\Application\ReadModel\MemberList\MemberListProjector::class,
        \Francken\Application\ReadModel\PostList\PostListProjector::class,
    ],
];
