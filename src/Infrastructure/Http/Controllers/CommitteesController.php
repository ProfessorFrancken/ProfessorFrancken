<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers;

use Francken\Application\Committees\CommitteesRepository;

final class CommitteesController
{
    private $committees;

    public function __construct(CommitteesRepository $repo)
    {
        $this->committees = $repo;
    }

    public function index()
    {
        $committees = $this->committees->list();

        return view('committees.index')
            ->with('committees', $committees);
    }

    public function show($link)
    {
        $committees = $this->committees->list();
        $committee = $this->committees->findByLink($link);

        $view = view($committee->page());

        return $view->with('committee', $committee)
            ->with('committees', $committees);
    }
}
