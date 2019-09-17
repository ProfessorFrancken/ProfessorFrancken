<?php

declare(strict_types=1);

namespace Francken\Application\Career;

final class EventRepository
{
    private $events;
    private $plannedEvents;
    private $pastEvents;

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

        if ($pastEvents === null) {
            return [];
        }

        return $pastEvents;
    }

    public function plannedInYear(AcademicYear $year) : array
    {
        $plannedEvents = array_filter(
            $this->plannedEvents,
            $this->filterByAcademicYear($year)
        );

        if ($plannedEvents === null) {
            return [];
        }

        return $plannedEvents;
    }

    private function filterByAcademicYear($year)
    {
        return function (array $event) use ($year) {
            return AcademicYear::fromString($event['academicYear']) == $year;
        };
    }
}
