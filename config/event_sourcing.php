<?php

return [
    'event_store_table' => 'event_store',

    'projectors' => [
        \App\ReadModel\CommitteesList\CommitteesListProjector::class,
    ],
];
