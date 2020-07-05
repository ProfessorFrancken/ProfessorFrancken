<?php

declare(strict_types=1);

namespace Francken\PlusOne\Http;

use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

final class ProductsController
{
    private Builder $products;

    public function __construct(ConnectionResolverInterface $db)
    {
        $this->products = $db->connection('francken-legacy')
                        ->table('producten');
    }

    public function index() : Collection
    {
        $products = $this->products->where('beschikbaar', 1)
                  ->leftJoin('producten_extras', 'producten.id', 'producten_extras.product_id')
                  ->get()
                  ->map(function ($product) {
                      if ($product->afbeelding !== null) {
                          $product->afbeelding = "https://old.professorfrancken.nl/database/streep/afbeeldingen/{$product->afbeelding}";
                      }
                      if ($product->splash_afbeelding !== null) {
                          $product->splash_afbeelding = "https://old.professorfrancken.nl/database/streep/afbeeldingen/{$product->splash_afbeelding}";
                      }
                      return $product;
                  });

        return collect(['products' => $products]);
    }
}
