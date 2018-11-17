<?php

declare(strict_types=1);

namespace Francken\Api\PlusOne\Http;

use DB;
use DateTimeImmutable;
use DateInterval;

final class CategoryStatisticsController
{
    public function index()
    {
        $db = DB::connection('francken-legacy');
        $today = new DateTimeImmutable;

        $stats = $db->table('transacties')
            ->orderBy('tijd', 'desc')
            ->join('producten', 'transacties.product_id', '=', 'producten.id')
            ->select([
                DB::raw('sum(aantal) as amount'),
                'categorie',
                DB::raw('DATE_FORMAT(tijd, "%Y-%m-%d") as date')
            ])
            ->groupBy('date', 'categorie')
            ->whereBetween('tijd', [$today->sub(new DateInterval('P1Y')), $today])
            ->get();

        return $stats;
    }
}
