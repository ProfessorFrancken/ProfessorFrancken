<?php

declare(strict_types=1);

namespace Francken\Domain\Boards;

use DateTimeImmutable;

final class Board
{
    public $year;
    public $name;
    public $members;
    public $photo;
    private $boardYear;

    private $policyPlan;
    private $yearReview;

    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->members = $data['members'];
        $this->photo = $data['figure'];
        $this->photoPosition = $data['figurePosition'];
        $this->parseYear($data['year']);
    }

    public function name() : string
    {
        return $this->name;
    }

    public function members() : array
    {
        return $this->members;
    }

    public function photo() : string
    {
        return $this->photo;
    }

    public function photoPosition() : string
    {
        return $this->photoPosition;
    }

    public function boardYear() : BoardYear
    {
        return $this->boardYear;
    }

    public function startOfYear() : DateTimeImmutable
    {
        return $this->boardYear->start();
    }

    public function endOfYear() : DateTimeImmutable
    {
        return $this->boardYear->end();
    }

    /**
     * Assume that $year is of the form yyyy-yyyy and get the start and end year
     * from it. Moreover assume that a board year starts and ends at the 7th of June
     */
    private function parseYear(string $year)
    {
        preg_match('/(\d{4})-(\d{4})/', $year, $matches);

        $start = new DateTimeImmutable('06-07-' . $matches[1]);
        $end = new DateTimeImmutable('06-07-' . $matches[2]);

        $this->boardYear = BoardYear::from($start, $end);
    }
}
