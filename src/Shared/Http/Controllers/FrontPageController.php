<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Controllers;

use DateTimeImmutable;
use DateTimeZone;
use Francken\Association\Activities\Activity;
use Francken\Association\FranckenVrij\Edition;
use Francken\Association\News\News;
use Francken\Shared\Page;
use Francken\Shared\Settings\Settings;
use Illuminate\View\View;

class FrontPageController extends Controller
{
    public function index(Settings $settings) : View
    {
        $today = new DateTimeImmutable(
            'now',
            new DateTimeZone('Europe/Amsterdam')
        );

        $latestEdition = Edition::query()
            ->latestEdition()
            ->first();

        $news = News::query()->recent()->limit(3)->get();

        $activities = Activity::query()
             ->with(['signUpSettings', 'signUps'])
             ->withCount(['comments'])
            ->after($today)
            ->orderBy('start_date', 'asc')
            ->limit(8)
            ->get();

        $covid = Page::covid()->where('is_published', true)->first();

        return view('homepage/homepage', [
            'header_image' => $settings->headerImage(),
            'news' => $news,
            'activities' => $activities,
            'latest_edition' => $latestEdition,
            'covid' => $covid,
        ]);
    }
}
