<?php

declare(strict_types=1);

namespace Francken\Borrelcie;

use League\Period\Period;

final class LeaderBoardController
{
    public function index()
    {
        $start = request()->get('start');
        $end = request()->get('end');
        $period = new Period($start, $end);

        $categoryId = request()->get('category');
        $limit = 100;


        $leaderBoard = DB::connection('francken-legacy')
            ->table('transacties')
            // blabla
            ->get();

        $leaderBoard->map(function ($member) {
            // Anonymise member

        });

        return $leaderBoard;
    }
}
