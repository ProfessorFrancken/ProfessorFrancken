<?php

return [
    'event_store_table' => 'event_store',

    'projectors' => [
        \Francken\Application\ReadModel\CommitteesList\CommitteesListProjector::class,
        \Francken\Application\ReadModel\MemberList\MemberListProjector::class,
        \Francken\Application\ReadModel\PostList\PostListProjector::class,
    ],
];
