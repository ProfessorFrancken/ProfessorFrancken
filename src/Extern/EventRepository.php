<?php

declare(strict_types=1);

namespace Francken\Extern;

use Francken\Shared\AcademicYear;

final class EventRepository
{
    /**
     * @var mixed[]
     */
    private array $plannedEvents = [];

    /**
     * @var mixed[]
     */
    private array $pastEvents = [];

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

    private function filterByAcademicYear($year) : callable
    {
        return function (array $event) use ($year) : bool {
            return AcademicYear::fromString($event['academicYear']) == $year;
        };
    }
}
