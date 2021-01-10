<?php

declare(strict_types=1);

namespace Francken\PlusOne\Http;

use DateTimeImmutable;
use Francken\Treasurer\Product;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Log;

final class OrdersController
{
    private ConnectionInterface $orders;

    public function __construct(ConnectionResolverInterface $db)
    {
        $this->orders = $db->connection('francken-legacy');
    }

    public function index() : Collection
    {
        $orders = $this->orders->table('transacties')
            ->take(100)
            ->orderBy('tijd', 'DESC')
            ->get()
            ->map(fn ($transactie) : array => [
                'id' => $transactie->id,
                'member_id' => $transactie->lid_id,
                'product_id' => $transactie->product_id,
                'amount' => $transactie->aantal,
                'ordered_at' => $transactie->tijd,
                'price' => $transactie->totaalprijs,
            ]);

        return collect(['orders' => $orders]);
    }

    public function store(Request $request) : Response
    {
        Log::info(
            'Buying an order',
            ['ip' => $request->ip(), 'order' => $request->get('order')]
        );

        $order = $request->get('order');

        foreach ($order['products'] as $product) {
            $productFromDb = Product::findOrFail($product['id']);

            if ( ! ($productFromDb instanceof Product)) {
                Log::error("Tried to buy a non existing product", $product);
                continue;
            }

            $this->orders->table('transacties')
                ->insert([
                    "lid_id" => $order['member']['id'],
                    "product_id" => $product['id'],
                    "aantal" =>	1,
                    "prijs" => $productFromDb->prijs,
                    "totaalprijs" => $productFromDb->prijs,
                    "tijd" => (new DateTimeImmutable())->setTimestamp(
                        (int)($order['ordered_at'] / 1000)
                    )
                ]);
        }

        return response(['create' => 'ok'], 201);
    }
}
