<?php

declare(strict_types=1);

namespace Francken\Application\Career;

final class EventRepository
{
    private $events;

    public function __construct(array $plannedEvents, array $pastEvents)
    {
        $this->plannedEvents = $plannedEvents;
        $this->pastEvents = $pastEvents;
    }

    public function pastInYear(AcademicYear $year) : array
    {
        return array_filter(
            $this->pastEvents,
            $this->filterByAcademicYear($year)
        );
    }

    public function plannedInYear(AcademicYear $year) : array
    {
        return array_filter(
            $this->plannedEvents,
            $this->filterByAcademicYear($year)
        );
    }

    private function filterByAcademicYear($year)
    {
        return function (array $event) use ($year) {
            return AcademicYear::fromString($event['academicYear']) == $year;
        };
    }
}
