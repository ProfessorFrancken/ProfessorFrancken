<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Controllers;

use Francken\Association\Activities\ActivitiesRepository;
use Francken\Association\FranckenVrij\FranckenVrijRepository;
use Francken\Association\News\Repository as NewsRepository;

class MainContentController extends Controller
{
    public function index(
        NewsRepository $news,
        ActivitiesRepository $activities,
        FranckenVrijRepository $francken_vrij
    ) {
        $today = new \DateTimeImmutable(
            'now', new \DateTimeZone('Europe/Amsterdam')
        );


        return view('homepage/homepage', [
            'news' => $news->recent(3),
            'activities' => $activities->after($today, 5),
            'latest_edition' => $francken_vrij->latestEdition()
        ]);
    }

    public function about()
    {
        return view('about');
    }

    public function post()
    {
        return view('news');
    }

    public function news()
    {
        return view('news', [
            'posts' => []
        ]);
    }

    public function blog()
    {
        return view('news', [
            'posts' => []
        ]);
    }

    public function study()
    {
        return view('study');
    }

    public function career()
    {
        return view('career');
    }

    public function association()
    {
        return view('association');
    }

    public function boards()
    {
        return view('boards');
    }

    public function history()
    {
        return view('history');
    }

    /**
     * This is a quick and dirty way of making it easy to add new (static pages)
     * it comes with the disadvantage that you cannot control the data passed to
     * the views, though you can possibly fix this by using view composers
     */
    public function page(string $page)
    {
        try {
            if ($this->pageCorrespondsToPartialView($page)) {
                throw new \InvalidArgumentException();
            }


            return view('pages.' . $page, [
                'posts' => [],
                'editPageUrl' => $this->getEditUrlForThisPage($page)
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->view('errors.404', [], 404);
        }
    }

    /**
     * By convention all partial views should start with an underscore. Hence we
     * check that the last part of the page URL starts with an underscore
     */
    private function pageCorrespondsToPartialView(string $page) : bool
    {
        $parts = explode('/', $page);

        return end($parts)[0] === '_';
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
            $firstLine = $stringfromfile[0];
            $explodedstring = explode("/", $firstLine, 3);
            $branchname = trim(preg_replace('/\s+/', ' ', $explodedstring[2]));
        } catch (\Exception $e) {
            $branchname = 'master';
        }

        return "https://github.com/ProfessorFrancken/ProfessorFrancken/edit/${branchname}/resources/views/pages/${page}.blade.php";
    }
}
