<?php

declare(strict_types=1);

namespace Francken\Borrelcie\Http;

final class ProductLeaderBoardController
{

    public function index()
    {
        $products = DB::connection('francken-legacy')
            ->table('producten')
            ->get();

        return $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->naam,
                'category' => $product->categorie
            ];
        });
    }

    public function show($productId)
    {
        // Get leaderboard for this product in a specific period
        $products = DB::connection('francken-legacy')
            ->table('transacties')
            ->get();
    }
}
