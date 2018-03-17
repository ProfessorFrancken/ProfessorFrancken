<?php

declare(strict_types=1);

namespace Francken\PlusOne\Http;

use Illuminate\Database\DatabaseManager;

final class OrdersController
{
    private $orders;

    public function __construct(DatabaseManager $db)
    {
        $this->orders = $db->connection('francken-legacy');
    }

    public function post()
    {
        $member = request()->get('member');
        $order = request()->get('order');

        return [$member, $order];
    }
}
