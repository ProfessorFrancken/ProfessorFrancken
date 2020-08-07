<?php

declare(strict_types=1);

namespace Francken\Association\Activities;

use Francken\Shared\Markdown\ContentCompiler;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportActivitiesFromCalendar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activities:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Import calendar events as activities";

    /**
     * Execute the console command.
     */
    public function handle(ActivitiesRepository $repo, ContentCompiler $markdown) : void
    {
        $calendarEvents = $repo->all();
        $calendarEvents->each(function (CalendarEvent $calendarEvent) use ($markdown) : void {
            $content = $markdown->content(trim($calendarEvent->description()));

            Activity::updateOrCreate(
                ['google_calendar_uid' => $calendarEvent->uid()],
                [
                    'name' => $calendarEvent->name(),
                    'slug' => sprintf(
                        "%s-%s",
                        $calendarEvent->startDate()->format('Y-m-d'),
                        Str::slug($calendarEvent->name())
                    ),
                    'summary' => $calendarEvent->shortDescription(),
                    'source_content' => $content->originalMarkdown(),
                    'compiled_content' => $content->compiledContent(),
                    'location' => $calendarEvent->location(),
                    'start_date' => $calendarEvent->startDate(),
                    'end_date' => $calendarEvent->endDate(),
                ]
            );
        });
    }
}
