<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Controllers;

use DateTimeImmutable;
use DateTimeZone;
use Exception;
use Francken\Association\Activities\Activity;
use Francken\Association\FranckenVrij\Edition;
use Francken\Association\News\News;
use Illuminate\View\View;
use Webmozart\Assert\Assert;

class FrontPageController extends Controller
{
    public function index() : View
    {
        $today = new DateTimeImmutable(
            'now', new DateTimeZone('Europe/Amsterdam')
        );

        $latestEdition = Edition::query()
            ->latestEdition()
            ->first();

        $news = News::recent()->limit(3)->get();

        $activities = Activity::query()
             ->with(['signUpSettings', 'signUps'])
             ->withCount(['comments'])
            ->after($today)
            ->orderBy('start_date', 'asc')
            ->limit(5)
            ->get();

        return view('homepage/homepage', [
            'news' => $news,
            'activities' => $activities,
            'latest_edition' => $latestEdition,
        ]);
    }

    /**
     * Based on the current branch that is used by git, make a url so that users
     * can easily edit this page
     */
    private function getEditUrlForThisPage(string $page) : string
    {
        $branchname = '';

        try {
            $stringfromfile = file(base_path('.git/HEAD'), FILE_USE_INCLUDE_PATH);
            Assert::isArray($stringfromfile);

            $firstLine = $stringfromfile[0];
            $explodedstring = explode("/", $firstLine, 3);
            $branchname = trim(preg_replace('/\s+/', ' ', $explodedstring[2]));
        } catch (Exception $e) {
            $branchname = 'master';
        }

        return "https://github.com/ProfessorFrancken/ProfessorFrancken/edit/${branchname}/resources/views/pages/${page}.blade.php";
    }
}
