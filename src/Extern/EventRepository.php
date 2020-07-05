<?php

declare(strict_types=1);

namespace Francken\Extern;

use Francken\Shared\AcademicYear;

final class EventRepository
{
    private array $plannedEvents;
    private array $pastEvents;

    public function __construct(array $plannedEvents, array $pastEvents)
    {
        $this->plannedEvents = $plannedEvents;
        $this->pastEvents = $pastEvents;
    }

    public function pastInYear(AcademicYear $year) : array
    {
        $pastEvents = array_filter(
            $this->pastEvents,
            $this->filterByAcademicYear($year)
        );

        return $pastEvents;
    }

    public function plannedInYear(AcademicYear $year) : array
    {
        $plannedEvents = array_filter(
            $this->plannedEvents,
            $this->filterByAcademicYear($year)
        );

        return $plannedEvents;
    }

    private function filterByAcademicYear($year) : callable
    {
        return function (array $event) use ($year) : bool {
            return AcademicYear::fromString($event['academicYear']) == $year;
        };
    }
}
