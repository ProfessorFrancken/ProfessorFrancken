<?php

declare(strict_types=1);

namespace Francken\Association\Committees;

final class HardcodedCommitteeMember
{
    private $id;
    private $fullName;

    public function __construct($id, string $fullName)
    {
        $this->id = $id;
        $this->fullName = $fullName;
    }

    public function id()
    {
        return $this->id;
    }

    public function fullName() : string
    {
        return $this->fullName;
    }
}
