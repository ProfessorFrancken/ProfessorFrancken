<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Controllers;

use Exception;
use Illuminate\View\View;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

class MainContentController extends Controller
{
    /**
     * This is a quick and dirty way of making it easy to add new (static pages)
     * it comes with the disadvantage that you cannot control the data passed to
     * the views, though you can possibly fix this by using view composers
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function page(string $page)
    {
        try {
            if ($this->pageCorrespondsToPartialView($page)) {
                throw new InvalidArgumentException();
            }


            $viewName = 'pages.' . $page;
            if ( ! view()->exists($viewName)) {
                throw new InvalidArgumentException();
            }

            return view($viewName, [
                'posts' => [],
                'editPageUrl' => $this->getEditUrlForThisPage($page)
            ]);
        } catch (InvalidArgumentException $e) {
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

        if (count($parts) > 0) {
            $view = $parts[count($parts) - 1];
            return strlen($view) > 0 && $view[0] === '_';
        }

        return false;
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
            $branchname = trim(preg_replace('/\s+/', ' ', $explodedstring[2]) ?? '');
        } catch (Exception $e) {
            $branchname = 'master';
        }

        return "https://github.com/ProfessorFrancken/ProfessorFrancken/edit/${branchname}/resources/views/pages/${page}.blade.php";
    }
}
