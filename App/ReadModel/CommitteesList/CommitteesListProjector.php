<?php

namespace App\ReadModel\CommitteesList;

use Illuminate\Database\ConnectionInterface as Connection;

use Broadway\ReadModel\Projector;

use Francken\Committees\Events\CommitteeInstantiated;

final class CommitteesListProjector extends Projector
{
    const TABLE = 'committees_list';

    private $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function applyCommitteeInstantiated(CommitteeInstantiated $event)
    {
        $this->db->table(self::TABLE)->insert([
            'uuid' => $event->committeeId(),
            'name' => $event->name(),
            'goal' => $event->goal()
        ]);
    }
}